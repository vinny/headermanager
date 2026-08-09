<?php
/**
*
* Header Manager extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 Vinny <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\headermanager\tests\event;

use PHPUnit\Framework\TestCase;
use vinny\headermanager\event\main_listener;

class main_listener_test extends TestCase
{
	protected $config;
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $phpbb_root_path = './';
	protected $php_ext = 'php';
	protected $images_table = 'phpbb_headermanager_images';
	protected $forums_table = 'phpbb_headermanager_forums';

	protected function setUp(): void
	{
		$this->config = new \phpbb\config\config([
			'vinny_headermanager_enable' => 0,
		]);
		$this->db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$this->request = $this->createMock(\phpbb\request\request::class);
		$this->template = $this->createMock(\phpbb\template\template::class);
		$this->user = $this->createMock(\phpbb\user::class);
	}

	public function test_get_subscribed_events()
	{
		$events = main_listener::getSubscribedEvents();
		$this->assertArrayHasKey('core.page_header', $events);
		$this->assertEquals('on_page_header', $events['core.page_header']);
	}

	public function test_on_page_header_disabled()
	{
		$this->template->expects($this->never())
			->method('assign_vars');

		$listener = new main_listener(
			$this->config,
			$this->db,
			$this->request,
			$this->template,
			$this->user,
			$this->phpbb_root_path,
			$this->php_ext,
			$this->images_table,
			$this->forums_table
		);

		$listener->on_page_header();
	}
}
