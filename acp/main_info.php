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
* Header Manager ACP module info class.
*/
class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\vinny\headermanager\acp\main_module',
			'title'		=> 'ACP_HEADERMANAGER_TITLE',
			'modes'		=> [
				'settings' => [
					'title' => 'HEADERMANAGER_SETTINGS',
					'auth'  => 'ext_vinny/headermanager && acl_a_board',
					'cat'   => ['ACP_HEADERMANAGER_TITLE'],
				],
				'logo'     => [
					'title' => 'HEADERMANAGER_LOGO',
					'auth'  => 'ext_vinny/headermanager && acl_a_board',
					'cat'   => ['ACP_HEADERMANAGER_TITLE'],
				],
				'images'   => [
					'title' => 'HEADERMANAGER_IMAGES',
					'auth'  => 'ext_vinny/headermanager && acl_a_board',
					'cat'   => ['ACP_HEADERMANAGER_TITLE'],
				],
				'forums'   => [
					'title' => 'HEADERMANAGER_FORUMS',
					'auth'  => 'ext_vinny/headermanager && acl_a_board',
					'cat'   => ['ACP_HEADERMANAGER_TITLE'],
				],
			],
		];
	}
}
