<?php
/**
*
* Header Manager extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 Vinny <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\headermanager\migrations\v100;

/**
* Migration 1: Initial config settings
*/
class initial_config extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['vinny_headermanager_enable']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	public function update_data()
	{
		return [
			['config.add', ['vinny_headermanager_enable', 1]],
			['config.add', ['vinny_headermanager_enable_custom_logo', 0]],
			['config.add', ['vinny_headermanager_custom_logo_img', '']],
			['config.add', ['vinny_headermanager_custom_logo_width', 0]],
			['config.add', ['vinny_headermanager_custom_logo_height', 0]],
			['config.add', ['vinny_headermanager_height', 0]],
			['config.add', ['vinny_headermanager_border_radius', 0]],
			['config.add', ['vinny_headermanager_clickable', 0]],
			['config.add', ['vinny_headermanager_show_logo', 1]],
			['config.add', ['vinny_headermanager_show_sitename', 1]],
			['config.add', ['vinny_headermanager_show_sitedesc', 1]],
			['config.add', ['vinny_headermanager_show_search', 1]],
			['config.add', ['vinny_headermanager_center_elements', 0]],
		];
	}
}
