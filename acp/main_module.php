<?php
/**
*
* Header Manager extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 Vinny <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\headermanager\acp;

/**
* Header Manager ACP module class.
*/
class main_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	protected function upload_image($form_field_name, $destination_dir, $prefix = '')
	{
		global $phpbb_container, $phpbb_root_path;

		$files_upload = $phpbb_container->get('files.upload');
		$filesystem = $phpbb_container->get('filesystem');

		$full_destination = $phpbb_root_path . $destination_dir;
		if (!$filesystem->exists($full_destination))
		{
			$filesystem->mkdir($full_destination, 0755);
		}

		$files_upload->reset_vars();
		$files_upload->set_allowed_extensions(['gif', 'jpg', 'jpeg', 'png', 'webp']);

		$file = $files_upload->handle_upload('files.types.form', $form_field_name);
		$file->clean_filename('unique_ext', $prefix);

		if (!$file->move_file($destination_dir))
		{
			$file->set_error('FILE_MOVE_UNSUCCESSFUL');
		}

		if (count($file->error))
		{
			return [
				'success' => false,
				'error'   => $file->error[0],
			];
		}

		return [
			'success'  => true,
			'filename' => $file->get('realname'),
		];
	}

	public function main($id, $mode)
	{
		global $config, $db, $request, $template, $user, $phpbb_container, $phpbb_root_path;

		$user->add_lang_ext('vinny/headermanager', 'headermanager');

		$images_table = $phpbb_container->getParameter('vinny.headermanager.tables.images');
		$forums_table = $phpbb_container->getParameter('vinny.headermanager.tables.forums');

		switch ($mode)
		{
			case 'settings':
				$this->tpl_name = 'acp_headermanager_config';
				$this->page_title = $user->lang('HEADERMANAGER_SETTINGS');

				$form_key = 'acp_headermanager_config';
				add_form_key($form_key);

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key($form_key))
					{
						trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$config->set('vinny_headermanager_enable', $request->variable('enable', 0));
					$config->set('vinny_headermanager_height', $request->variable('height', 140));
					$config->set('vinny_headermanager_border_radius', $request->variable('border_radius', 0));
					$config->set('vinny_headermanager_clickable', $request->variable('clickable', 0));
					$config->set('vinny_headermanager_show_logo', $request->variable('show_logo', 0));
					$config->set('vinny_headermanager_show_sitename', $request->variable('show_sitename', 0));
					$config->set('vinny_headermanager_show_sitedesc', $request->variable('show_sitedesc', 0));
					$config->set('vinny_headermanager_show_search', $request->variable('show_search', 0));
					$config->set('vinny_headermanager_center_elements', $request->variable('center_elements', 0));

					trigger_error($user->lang('HM_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}

				$template->assign_vars([
					'S_HM_ENABLE'			=> (bool) $config['vinny_headermanager_enable'],
					'HM_HEIGHT'				=> (int) $config['vinny_headermanager_height'],
					'HM_BORDER_RADIUS'		=> (int) $config['vinny_headermanager_border_radius'],
					'S_HM_CLICKABLE'		=> (bool) $config['vinny_headermanager_clickable'],
					'S_HM_SHOW_LOGO'		=> (bool) $config['vinny_headermanager_show_logo'],
					'S_HM_SHOW_SITENAME'	=> (bool) $config['vinny_headermanager_show_sitename'],
					'S_HM_SHOW_SITEDESC'	=> (bool) $config['vinny_headermanager_show_sitedesc'],
					'S_HM_SHOW_SEARCH'		=> (bool) $config['vinny_headermanager_show_search'],
					'S_HM_CENTER_ELEMENTS'	=> (bool) $config['vinny_headermanager_center_elements'],
					'U_ACTION'				=> $this->u_action,
				]);
			break;

			case 'logo':
				$this->tpl_name = 'acp_headermanager_logo';
				$this->page_title = $user->lang('HEADERMANAGER_LOGO');

				$form_key = 'acp_headermanager_logo';
				add_form_key($form_key);

				$action = $request->variable('action', '');

				// Handle delete logo action with confirmation box & AJAX support
				if ($action === 'delete_logo')
				{
					if (check_link_hash($request->variable('hash', ''), 'delete_logo'))
					{
						if (confirm_box(true))
						{
							$filename_logo = (string) $config['vinny_headermanager_custom_logo_img'];
							if ($filename_logo)
							{
								$filesystem = $phpbb_container->get('filesystem');
								$file_path = $phpbb_root_path . 'images/headermanager/' . $filename_logo;
								if ($filesystem->exists($file_path))
								{
									$filesystem->remove($file_path);
								}
								$config->set('vinny_headermanager_custom_logo_img', '');
							}

							trigger_error($user->lang('HM_LOGO_DELETED_SUCCESS') . adm_back_link($this->u_action));
						}
						else
						{
							confirm_box(false, $user->lang('HM_LOGO_DELETE_CONFIRM'), build_hidden_fields([
								'action' => 'delete_logo',
								'hash'   => generate_link_hash('delete_logo'),
							]));
						}
					}
				}

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key($form_key))
					{
						trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$config->set('vinny_headermanager_enable_custom_logo', $request->variable('enable_custom_logo', 0));
					$config->set('vinny_headermanager_custom_logo_width', $request->variable('custom_logo_width', 0));
					$config->set('vinny_headermanager_custom_logo_height', $request->variable('custom_logo_height', 0));

					// Handle custom logo upload using phpbb/ads model
					$upload_result = $this->upload_image('custom_logo_file', 'images/headermanager', 'logo_');
					if ($upload_result['success'])
					{
						$new_logo_filename = $upload_result['filename'];
						$old_logo = (string) $config['vinny_headermanager_custom_logo_img'];

						if (!empty($old_logo) && $old_logo !== $new_logo_filename)
						{
							$filesystem = $phpbb_container->get('filesystem');
							$old_path = $phpbb_root_path . 'images/headermanager/' . $old_logo;
							if ($filesystem->exists($old_path))
							{
								$filesystem->remove($old_path);
							}
						}

						$config->set('vinny_headermanager_custom_logo_img', $new_logo_filename);
					}
					else if ($upload_result['error'] !== 'NO_FILE')
					{
						$error_msg = isset($user->lang[$upload_result['error']]) ? $user->lang[$upload_result['error']] : $upload_result['error'];
						trigger_error($error_msg . adm_back_link($this->u_action), E_USER_WARNING);
					}

					trigger_error($user->lang('HM_LOGO_SETTINGS_SAVED') . adm_back_link($this->u_action));
				}

				$logo_filename = (string) $config['vinny_headermanager_custom_logo_img'];
				$logo_url = '';
				if (!empty($logo_filename))
				{
					$logo_url = $phpbb_root_path . 'images/headermanager/' . $logo_filename;
				}

				$template->assign_vars([
					'S_HM_ENABLE_CUSTOM_LOGO'	=> (bool) $config['vinny_headermanager_enable_custom_logo'],
					'HM_CUSTOM_LOGO_URL'		=> $logo_url,
					'HM_CUSTOM_LOGO_WIDTH'		=> (int) $config['vinny_headermanager_custom_logo_width'],
					'HM_CUSTOM_LOGO_HEIGHT'		=> (int) $config['vinny_headermanager_custom_logo_height'],
					'U_DELETE_LOGO'				=> $this->u_action . '&amp;action=delete_logo&amp;hash=' . generate_link_hash('delete_logo'),
					'U_ACTION'					=> $this->u_action,
				]);
			break;

			case 'images':
				$this->tpl_name = 'acp_headermanager_images';
				$this->page_title = $user->lang('HEADERMANAGER_IMAGES');

				$form_key = 'acp_headermanager_images';
				add_form_key($form_key);

				$action = $request->variable('action', '');
				$image_id = $request->variable('id', 0);

				if ($action === 'delete' && $image_id > 0)
				{
					if (check_link_hash($request->variable('hash', ''), 'delete_' . $image_id))
					{
						if (confirm_box(true))
						{
							$sql = 'SELECT image_filename FROM ' . $images_table . ' WHERE image_id = ' . (int) $image_id;
							$result = $db->sql_query($sql);
							$filename = $db->sql_fetchfield('image_filename');
							$db->sql_freeresult($result);

							if ($filename)
							{
								$filesystem = $phpbb_container->get('filesystem');
								$file_path = $phpbb_root_path . 'images/headermanager/' . $filename;
								if ($filesystem->exists($file_path))
								{
									$filesystem->remove($file_path);
								}

								$sql = 'DELETE FROM ' . $images_table . ' WHERE image_id = ' . (int) $image_id;
								$db->sql_query($sql);

								$sql = 'UPDATE ' . $forums_table . ' SET image_id = 0 WHERE image_id = ' . (int) $image_id;
								$db->sql_query($sql);
							}

							if ($request->is_ajax())
							{
								$json_response = new \phpbb\json_response();
								$json_response->send([
									'MESSAGE_TITLE'	=> $user->lang('INFORMATION'),
									'MESSAGE_TEXT'	=> $user->lang('HM_IMAGE_DELETED_SUCCESS'),
									'REFRESH_DATA'	=> [
										'url'	=> $this->u_action,
										'time'	=> 3,
									],
								]);
							}

							trigger_error($user->lang('HM_IMAGE_DELETED_SUCCESS') . adm_back_link($this->u_action));
						}
						else
						{
							confirm_box(false, $user->lang('HM_IMAGE_DELETE_CONFIRM'), build_hidden_fields([
								'action' => 'delete',
								'id'     => $image_id,
								'hash'   => generate_link_hash('delete_' . $image_id),
							]));
						}
					}
				}

				if ($request->is_set_post('upload'))
				{
					if (!check_form_key($form_key))
					{
						trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$title = $request->variable('image_title', '', true);
					$image_type = $request->variable('image_type', 'global');
					if (!in_array($image_type, ['global', 'forum']))
					{
						$image_type = 'global';
					}

					// Handle banner upload using phpbb/ads model
					$upload_result = $this->upload_image('image_file', 'images/headermanager');
					if (!$upload_result['success'])
					{
						$error_msg = isset($user->lang[$upload_result['error']]) ? $user->lang[$upload_result['error']] : $upload_result['error'];
						trigger_error($error_msg . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$sql_ary = [
						'image_filename' => $upload_result['filename'],
						'image_title'    => $title,
						'image_type'     => $image_type,
						'upload_time'    => time(),
					];

					$sql = 'INSERT INTO ' . $images_table . ' ' . $db->sql_build_array('INSERT', $sql_ary);
					$db->sql_query($sql);

					trigger_error($user->lang('HM_IMAGE_UPLOADED_SUCCESS') . adm_back_link($this->u_action));
				}

				$sql = 'SELECT * FROM ' . $images_table . ' ORDER BY upload_time DESC';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('images', [
						'ID'       => $row['image_id'],
						'FILENAME' => $row['image_filename'],
						'TITLE'    => $row['image_title'],
						'TYPE'     => $row['image_type'],
						'DATE'     => $user->format_date($row['upload_time']),
						'URL'      => $phpbb_root_path . 'images/headermanager/' . $row['image_filename'],
						'U_DELETE' => $this->u_action . '&amp;action=delete&amp;id=' . $row['image_id'] . '&amp;hash=' . generate_link_hash('delete_' . $row['image_id']),
					]);
				}
				$db->sql_freeresult($result);

				$template->assign_vars([
					'U_ACTION' => $this->u_action,
				]);
			break;

			case 'forums':
				$this->tpl_name = 'acp_headermanager_forums';
				$this->page_title = $user->lang('HEADERMANAGER_FORUMS');

				$form_key = 'acp_headermanager_forums';
				add_form_key($form_key);

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key($form_key))
					{
						trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$forum_images = $request->variable('forum_image', [0 => 0]);

					foreach ($forum_images as $forum_id => $img_id)
					{
						$forum_id = (int) $forum_id;
						$img_id = (int) $img_id;

						if ($forum_id > 0)
						{
							if ($img_id > 0)
							{
								$sql = 'SELECT image_id FROM ' . $forums_table . ' WHERE forum_id = ' . (int) $forum_id;
								$result = $db->sql_query($sql);
								$exists = (bool) $db->sql_fetchfield('image_id');
								$db->sql_freeresult($result);

								if ($exists)
								{
									$sql = 'UPDATE ' . $forums_table . '
										SET ' . $db->sql_build_array('UPDATE', ['image_id' => (int) $img_id]) . '
										WHERE forum_id = ' . (int) $forum_id;
								}
								else
								{
									$sql = 'INSERT INTO ' . $forums_table . ' ' . $db->sql_build_array('INSERT', [
										'forum_id' => (int) $forum_id,
										'image_id' => (int) $img_id,
									]);
								}

								$db->sql_query($sql);
							}
							else
							{
								$sql = 'DELETE FROM ' . $forums_table . ' WHERE forum_id = ' . (int) $forum_id;
								$db->sql_query($sql);
							}
						}
					}

					trigger_error($user->lang('HM_FORUM_SAVED_SUCCESS') . adm_back_link($this->u_action));
				}

				$available_images = [];
				$sql = 'SELECT image_id, image_filename, image_title, image_type FROM ' . $images_table . " WHERE image_type = 'forum' ORDER BY image_filename ASC";
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$available_images[$row['image_id']] = [
						'id'       => $row['image_id'],
						'filename' => $row['image_filename'],
						'title'    => $row['image_title'] ? $row['image_title'] . ' (' . $row['image_filename'] . ')' : $row['image_filename'],
						'type'     => $row['image_type'],
						'url'      => $phpbb_root_path . 'images/headermanager/' . $row['image_filename'],
					];
				}
				$db->sql_freeresult($result);

				$assigned_forums = [];
				$sql = 'SELECT forum_id, image_id FROM ' . $forums_table;
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$assigned_forums[$row['forum_id']] = (int) $row['image_id'];
				}
				$db->sql_freeresult($result);

				$sql = 'SELECT forum_id, forum_name, parent_id, left_id, right_id FROM ' . FORUMS_TABLE . ' ORDER BY left_id ASC';
				$result = $db->sql_query($sql);

				while ($row = $db->sql_fetchrow($result))
				{
					$f_id = (int) $row['forum_id'];
					$current_img = isset($assigned_forums[$f_id]) ? $assigned_forums[$f_id] : 0;

					$options = [];
					$current_img_url = '';

					foreach ($available_images as $img_id => $img_info)
					{
						$is_selected = ($img_id == $current_img);
						if ($is_selected)
						{
							$current_img_url = $img_info['url'];
						}

						$options[] = [
							'ID'       => $img_id,
							'TITLE'    => $img_info['title'],
							'URL'      => $img_info['url'],
							'SELECTED' => $is_selected,
						];
					}

					$template->assign_block_vars('forums', [
						'FORUM_ID'        => $f_id,
						'FORUM_NAME'      => $row['forum_name'],
						'IMAGE_ID'        => $current_img,
						'CURRENT_IMG_URL' => $current_img_url,
						'OPTIONS'         => $options,
					]);
				}
				$db->sql_freeresult($result);

				$template->assign_vars([
					'U_ACTION' => $this->u_action,
				]);
			break;
		}
	}
}
