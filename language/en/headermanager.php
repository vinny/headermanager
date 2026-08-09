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
	// General settings
	'HEADERMANAGER_SETTINGS'			=> 'General settings',
	'HEADERMANAGER_SETTINGS_EXPLAIN'	=> 'Configure general header settings, background banner sizing, element visibility, and alignment.',
	'HM_GENERAL_SETTINGS'				=> 'General header settings',
	'HM_ENABLE'							=> 'Enable Header Manager',
	'HM_ENABLE_EXPLAIN'					=> 'Turn on or off the header customization features.',
	'HM_HEIGHT'							=> 'Headerbar minimum height',
	'HM_HEIGHT_EXPLAIN'					=> 'Set minimum height for the header container in pixels.',
	'HM_BORDER_RADIUS'					=> 'Headerbar border radius',
	'HM_BORDER_RADIUS_EXPLAIN'			=> 'Set rounded corners value in pixels. A single number applies to all four corners.',
	'HM_CLICKABLE'						=> 'Make whole headerbar clickable',
	'HM_CLICKABLE_EXPLAIN'				=> 'Allows clicking anywhere on the header background to return to the board index.',

	// Custom logo settings
	'HEADERMANAGER_LOGO'				=> 'Custom logo settings',
	'HEADERMANAGER_LOGO_EXPLAIN'		=> 'Upload and configure a custom logo to replace the default board logo.',
	'HM_CUSTOM_LOGO_SETTINGS'			=> 'Custom logo configuration',
	'HM_ENABLE_CUSTOM_LOGO'				=> 'Enable custom logo',
	'HM_ENABLE_CUSTOM_LOGO_EXPLAIN'		=> 'Replace the default board logo with an uploaded custom logo image.',
	'HM_CUSTOM_LOGO_UPLOAD'				=> 'Upload custom logo',
	'HM_CUSTOM_LOGO_UPLOAD_EXPLAIN'		=> 'Select a logo image file (PNG, JPG, JPEG, GIF, WEBP) from your device.',
	'HM_CUSTOM_LOGO_WIDTH'				=> 'Custom logo width',
	'HM_CUSTOM_LOGO_WIDTH_EXPLAIN'		=> 'Set explicit logo width in pixels. Leave 0 for original image width.',
	'HM_CUSTOM_LOGO_HEIGHT'				=> 'Custom logo height',
	'HM_CUSTOM_LOGO_HEIGHT_EXPLAIN'		=> 'Set explicit logo height in pixels. Leave 0 for original image height.',
	'HM_CURRENT_LOGO'					=> 'Current custom logo',
	'HM_DELETE_LOGO'					=> 'Delete logo',
	'HM_LOGO_DELETED_SUCCESS'			=> 'The custom logo image has been deleted.',
	'HM_LOGO_DELETE_CONFIRM'			=> 'Are you sure you want to delete the custom logo image?',
	'HM_LOGO_SETTINGS_SAVED'			=> 'Custom logo settings have been saved.',

	// Element visibility
	'HM_ELEMENT_VISIBILITY'				=> 'Element visibility',
	'HM_SHOW_LOGO'						=> 'Show site logo',
	'HM_SHOW_LOGO_EXPLAIN'				=> 'Display or hide the site logo image in the headerbar.',
	'HM_SHOW_SITENAME'					=> 'Show site name',
	'HM_SHOW_SITENAME_EXPLAIN'			=> 'Display or hide the main site name title in the headerbar.',
	'HM_SHOW_SITEDESC'					=> 'Show site description',
	'HM_SHOW_SITEDESC_EXPLAIN'			=> 'Display or hide the site description subtitle in the headerbar.',
	'HM_SHOW_SEARCH'					=> 'Show search box',
	'HM_SHOW_SEARCH_EXPLAIN'			=> 'Display or hide the header search input box.',

	// Alignment settings
	'HM_ALIGNMENT_SETTINGS'				=> 'Alignment settings',
	'HM_CENTER_ELEMENTS'				=> 'Center header elements',
	'HM_CENTER_ELEMENTS_EXPLAIN'		=> 'Center align all header elements (logo, site name, site description, and search box) both horizontally and vertically.',

	// Header background banners
	'HEADERMANAGER_IMAGES'				=> 'Header background banners',
	'HEADERMANAGER_IMAGES_EXPLAIN'		=> 'Upload and manage background header images stored in images/headermanager/.',
	'HM_UPLOAD_IMAGE'					=> 'Upload new image',
	'HM_UPLOAD_IMAGE_EXPLAIN'			=> 'Select an image file (PNG, JPG, JPEG, GIF, WEBP) from your device.',
	'HM_IMAGE_TITLE'					=> 'Image title',
	'HM_IMAGE_TITLE_EXPLAIN'			=> 'Optional descriptive label for this header image.',
	'HM_IMAGE_TYPE'						=> 'Banner type',
	'HM_IMAGE_TYPE_EXPLAIN'				=> 'Select whether this banner is for global random rotation or forum-specific assignment.',
	'HM_IMAGE_TYPE_GLOBAL'				=> 'Global random banner',
	'HM_IMAGE_TYPE_FORUM'				=> 'Forum specific banner',

	'HM_NO_IMAGES_UPLOADED'				=> 'No images uploaded yet.',
	'HM_UPLOADED_IMAGES'				=> 'Uploaded header images',
	'HM_PREVIEW'						=> 'Preview',
	'HM_FILENAME'						=> 'Filename',
	'HM_TITLE'							=> 'Title',
	'HM_TYPE'							=> 'Type',
	'HM_UPLOAD_DATE'					=> 'Date uploaded',
	'HM_DELETE'							=> 'Delete',

	'HM_IMAGE_UPLOADED_SUCCESS'			=> 'The image was uploaded.',
	'HM_IMAGE_DELETED_SUCCESS'			=> 'The header image has been deleted.',
	'HM_IMAGE_DELETE_CONFIRM'			=> 'Are you sure you want to delete this header image?',
	'HM_ERROR_NO_FILE'					=> 'Please select a valid image file to upload.',
	'HM_ERROR_UPLOAD'					=> 'An error occurred while uploading the file. Check file permissions on images/headermanager/.',
	'HM_ERROR_INVALID_TYPE'				=> 'The uploaded file is not a valid image format. Allowed formats: PNG, JPG, JPEG, GIF, WEBP.',

	// Forum images
	'HEADERMANAGER_FORUMS'				=> 'Forum specific header images',
	'HEADERMANAGER_FORUMS_EXPLAIN'		=> 'Assign specific header background images to individual forums, subforums, or categories.',
	'HM_FORUM_NAME'						=> 'Forum name',
	'HM_ASSIGNED_IMAGE'					=> 'Assigned header image',
	'HM_USE_GLOBAL'						=> '-- Use random global banner --',
	'HM_FORUM_SAVED_SUCCESS'			=> 'Forum image assignments have been saved.',
	'HM_SETTINGS_SAVED'					=> 'Header Manager settings have been saved.',
]);
