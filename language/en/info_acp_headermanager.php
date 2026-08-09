<?php
/**
*
* Header Manager extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 Vinny <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_HEADERMANAGER_TITLE'	=> 'Header Manager',
	'HEADERMANAGER_SETTINGS'	=> 'General settings',
	'HEADERMANAGER_LOGO'		=> 'Custom logo settings',
	'HEADERMANAGER_IMAGES'		=> 'Header background banners',
	'HEADERMANAGER_FORUMS'		=> 'Forum specific header images',
]);
