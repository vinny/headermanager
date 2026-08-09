<?php
/**
*
* Header Manager extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 Vinny <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\headermanager;

/**
* Header Manager extension base class.
*/
class ext extends \phpbb\extension\base
{
	/**
	* Create images/headermanager when extension is enabled
	*/
	public function enable_step($old_state)
	{
		if ($old_state === false)
		{
			$filesystem = $this->container->get('filesystem');
			$my_dir_path = $this->container->getParameter('core.root_path') . 'images/headermanager';

			try
			{
				$filesystem->mkdir($my_dir_path, 0755);
				$filesystem->touch($my_dir_path . '/index.htm');
			}
			catch (\phpbb\filesystem\exception\filesystem_exception $e)
			{
				// Intentionally ignored.
			}

			return 'added headermanager_dir';
		}

		return parent::enable_step($old_state);
	}

	/**
	* Delete images/headermanager when deleting extension data
	*/
	public function purge_step($old_state)
	{
		if ($old_state === false)
		{
			$filesystem = $this->container->get('filesystem');
			$my_dir_path = $this->container->getParameter('core.root_path') . 'images/headermanager';

			try
			{
				if ($filesystem->exists($my_dir_path))
				{
					$filesystem->remove($my_dir_path);
				}
			}
			catch (\phpbb\filesystem\exception\filesystem_exception $e)
			{
				// Intentionally ignored.
			}

			return 'removed headermanager_dir';
		}

		return parent::purge_step($old_state);
	}
}
