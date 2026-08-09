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
* Migration 3: Header Manager forums table
*/
class forums_table extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\vinny\headermanager\migrations\v100\images_table'];
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'headermanager_forums' => [
					'COLUMNS' => [
						'forum_id'	=> ['UINT', 0],
						'image_id'	=> ['UINT', 0],
					],
					'PRIMARY_KEY' => 'forum_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'headermanager_forums',
			],
		];
	}
}
