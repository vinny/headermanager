# Header Manager [![Build Status](https://github.com/vinny/headermanager/actions/workflows/tests.yml/badge.svg)](https://github.com/vinny/headermanager/actions/workflows/tests.yml)

Header Manager is a phpBB 3.3 extension that customises the board headerbar with random background banners, forum-specific header backgrounds, custom logo upload, custom sizing, element visibility controls, and clickable header behavior.

## Features

- **General settings:** Enable the extension, set custom height and border radius in pixels, toggle the clickable headerbar, adjust element visibility, and center all header elements horizontally and vertically.
- **Custom logo settings:** Upload a custom logo (PNG, JPG, JPEG, GIF, WEBP), set explicit width/height in pixels, and manage/delete custom logo images.
- **Header background banners:** Upload new background banners, select the banner type (Global random or Forum specific), and manage existing files with AJAX deletion.
- **Forum images:** Map specific header background banners to individual forums, subforums, or categories with live preview.


## Requirements

- phpBB 3.3.0 or higher
- PHP 7.2 or higher

## Installation

1. Download the latest release.
2. Copy the contents to `ext/vinny/headermanager`.
3. Navigate to **ACP > Customise > Manage extensions**.
4. Look for **Header Manager** under Disabled Extensions and click **Enable**.

## Uninstallation

1. Navigate to **ACP > Customise > Manage extensions**.
2. Look for **Header Manager** under Enabled Extensions and click **Disable**.
3. To permanently remove stored images and database tables, click **Delete data**.

## License

[![License](https://img.shields.io/badge/License-GPL%20v2-green.svg)](license.txt)
