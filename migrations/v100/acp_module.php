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
* Migration 4: ACP module registration
*/
class acp_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\vinny\headermanager\migrations\v100\forums_table'];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_HEADERMANAGER_TITLE'
			]],
			['module.add', [
				'acp',
				'ACP_HEADERMANAGER_TITLE',
				[
					'module_basename'	=> '\vinny\headermanager\acp\main_module',
					'modes'				=> ['settings', 'logo', 'images', 'forums'],
				]
			]],
		];
	}
}
