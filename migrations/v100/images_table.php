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
* Migration 2: Header Manager images table
*/
class images_table extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\vinny\headermanager\migrations\v100\initial_config'];
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'headermanager_images' => [
					'COLUMNS' => [
						'image_id'			=> ['UINT', null, 'auto_increment'],
						'image_filename'	=> ['VCHAR:255', ''],
						'image_title'		=> ['VCHAR:255', ''],
						'image_type'		=> ['VCHAR:20', 'global'],
						'upload_time'		=> ['TIMESTAMP', 0],
					],
					'PRIMARY_KEY' => 'image_id',
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'headermanager_images',
			],
		];
	}
}
