# Hide Empty Shortcode Spaces

A WordPress plugin that removes empty whitespace left by shortcodes (`GETSINGLEPOSTQNA`, `GETSINGLEPAGEDETAILS`) and tag containers (`tdb_single_tags`) when they have no content to display.

## Problem

When using shortcodes like `[GETSINGLEPOSTQNA]` or `[GETSINGLEPAGEDETAILS]` inside `[td_block_text_with_title]` wrappers, empty space appears on the page when:

- A post is not paid (no QnA content to show)
- A page has no details to display
- A post has no tags assigned (`[tdb_single_tags]` renders an empty container)

## How It Works

The plugin uses **three layers** to ensure empty containers are hidden:

1. **CSS** — Hides containers marked as empty via the `.hess-empty` class  
2. **JavaScript** — Detects and hides empty containers at runtime (handles AJAX / dynamically loaded content from the Flavor theme)  
3. **PHP Filters** — Strips empty `td_block_text_with_title` wrappers and hides `tdb_single_tags` when the post has no tags (server-side, before the page is sent to the browser)

## Installation

### Option 1: Upload as Plugin

1. Download/copy the `hide-empty-shortcode-spaces` folder
2. Upload it to `/wp-content/plugins/` on your WordPress site
3. Go to **WordPress Admin → Plugins**
4. Find **"Hide Empty Shortcode Spaces"** and click **Activate**

### Option 2: Add to functions.php

If you prefer not to use a separate plugin, copy the contents of `hide-empty-shortcode-spaces.php` (everything after the plugin header comment) into your theme's `functions.php` file.

## Usage

Once activated, the plugin works automatically — no configuration needed.

- Empty `[td_block_text_with_title]` wrappers (containing `[GETSINGLEPOSTQNA]` or `[GETSINGLEPAGEDETAILS]`) will be hidden when their shortcode output is empty.
- `[tdb_single_tags]` blocks will be hidden when the current post has no tags.
- Parent `[vc_row_inner]` / `[vc_column_inner]` containers will also be hidden if all their child blocks are empty (cascade cleanup).

## Compatibility

- WordPress 5.0+
- Flavor Theme / flavor Builder
- Visual Composer / WPBakery Page Builder
- Works with AJAX-loaded content (MutationObserver)
