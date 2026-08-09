<?php
/**
*
* Header Manager extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 Vinny <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\headermanager\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Header Manager Event Listener.
*/
class main_listener implements EventSubscriberInterface
{
	protected $config;
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $images_table;
	protected $forums_table;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$phpbb_root_path,
		$php_ext,
		$images_table,
		$forums_table
	)
	{
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->images_table = $images_table;
		$this->forums_table = $forums_table;
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.page_header' => 'on_page_header',
		];
	}

	public function on_page_header()
	{
		if (empty($this->config['vinny_headermanager_enable']))
		{
			return;
		}

		$forum_id = (int) $this->request->variable('f', 0);
		$header_image = '';

		if ($forum_id > 0)
		{
			$sql = 'SELECT i.image_filename
				FROM ' . $this->forums_table . ' f
				JOIN ' . $this->images_table . ' i ON (f.image_id = i.image_id)
				WHERE f.forum_id = ' . (int) $forum_id;
			$result = $this->db->sql_query($sql);
			$header_image = (string) $this->db->sql_fetchfield('image_filename');
			$this->db->sql_freeresult($result);
		}

		if (empty($header_image))
		{
			$sql = 'SELECT image_filename FROM ' . $this->images_table . " WHERE image_type = 'global'";
			$result = $this->db->sql_query($sql);
			$global_images = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$global_images[] = $row['image_filename'];
			}
			$this->db->sql_freeresult($result);

			if (!empty($global_images))
			{
				$header_image = $global_images[array_rand($global_images)];
			}
			else
			{
				// Fallback to any uploaded image if no global images exist
				$sql = 'SELECT image_filename FROM ' . $this->images_table;
				$result = $this->db->sql_query($sql);
				$all_images = [];
				while ($row = $this->db->sql_fetchrow($result))
				{
					$all_images[] = $row['image_filename'];
				}
				$this->db->sql_freeresult($result);

				if (!empty($all_images))
				{
					$header_image = $all_images[array_rand($all_images)];
				}
			}
		}

		$bg_url = '';
		if (!empty($header_image))
		{
			$bg_url = generate_board_url() . '/images/headermanager/' . $header_image;
		}

		$custom_logo_url = '';
		$enable_custom_logo = (bool) $this->config['vinny_headermanager_enable_custom_logo'];
		$custom_logo_filename = (string) $this->config['vinny_headermanager_custom_logo_img'];

		if ($enable_custom_logo && !empty($custom_logo_filename))
		{
			$custom_logo_url = generate_board_url() . '/images/headermanager/' . $custom_logo_filename;
		}

		$this->template->assign_vars([
			'S_HEADERMANAGER_ENABLED'			=> true,
			'HEADERMANAGER_BG_URL'				=> $bg_url,
			'S_HEADERMANAGER_CUSTOM_LOGO'		=> ($enable_custom_logo && !empty($custom_logo_url)),
			'HEADERMANAGER_LOGO_URL'			=> $custom_logo_url,
			'HEADERMANAGER_LOGO_WIDTH'			=> (int) $this->config['vinny_headermanager_custom_logo_width'],
			'HEADERMANAGER_LOGO_HEIGHT'			=> (int) $this->config['vinny_headermanager_custom_logo_height'],
			'HEADERMANAGER_HEIGHT'				=> (int) $this->config['vinny_headermanager_height'],
			'HEADERMANAGER_BORDER_RADIUS'		=> (int) $this->config['vinny_headermanager_border_radius'],
			'S_HEADERMANAGER_CLICKABLE'			=> (bool) $this->config['vinny_headermanager_clickable'],
			'S_HEADERMANAGER_SHOW_LOGO'			=> (bool) $this->config['vinny_headermanager_show_logo'],
			'S_HEADERMANAGER_SHOW_SITENAME'		=> (bool) $this->config['vinny_headermanager_show_sitename'],
			'S_HEADERMANAGER_SHOW_SITEDESC'		=> (bool) $this->config['vinny_headermanager_show_sitedesc'],
			'S_HEADERMANAGER_SHOW_SEARCH'		=> (bool) $this->config['vinny_headermanager_show_search'],
			'S_HEADERMANAGER_CENTER_ELEMENTS'	=> (bool) $this->config['vinny_headermanager_center_elements'],
		]);
	}
}
