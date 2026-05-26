<?php
/**
 * Plugin Name: Hide Empty Shortcode Spaces
 * Description: Removes empty whitespace left by shortcodes (GETSINGLEPOSTQNA, GETSINGLEPAGEDETAILS) and empty tag containers (tdb_single_tags) when they have no content to display.
 * Version: 1.0.0
 * Author: Bhavani Rani
 * License: MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ──────────────────────────────────────────────────────────────
 * 1. CSS — hide any wrapper that ends up visually empty
 * ──────────────────────────────────────────────────────────────
 */
add_action( 'wp_head', 'hess_inline_css' );
function hess_inline_css() {
    ?>
    <style id="hide-empty-shortcode-spaces">
        /* Hide td_block_text_with_title wrappers that contain no visible content */
        .td_block_text_with_title .tdb-block-inner:empty,
        .td_block_text_with_title .tdb-block-inner:not(:has(* :not(br))):not(:has(img)) {
            display: none !important;
        }

        /* Hide the entire td_block when its inner content is empty */
        .td_block_text_with_title.hess-empty {
            display: none !important;
            margin: 0 !important;
            padding: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* Hide tdb_single_tags block when no tags exist */
        .tdb_single_tags.hess-empty {
            display: none !important;
            margin: 0 !important;
            padding: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* Generic: hide any shortcode wrapper marked empty */
        .hess-empty {
            display: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
    <?php
}

/**
 * ──────────────────────────────────────────────────────────────
 * 2. JavaScript — detect and hide empty containers at runtime
 *    (handles dynamic / AJAX-loaded content from Flavor theme)
 * ──────────────────────────────────────────────────────────────
 */
add_action( 'wp_footer', 'hess_inline_js', 100 );
function hess_inline_js() {
    ?>
    <script id="hide-empty-shortcode-spaces-js">
    (function () {
        'use strict';

        /**
         * Check if an element is visually empty:
         * no meaningful text, no images, no iframes, no embeds.
         */
        function isVisuallyEmpty(el) {
            if (!el) return true;

            // Has images, iframes, embeds, videos, canvases — not empty
            if (el.querySelector('img, iframe, video, embed, object, canvas, svg')) {
                return false;
            }

            // Strip whitespace and check text
            var text = (el.textContent || '').replace(/\s+/g, '').trim();
            return text.length === 0;
        }

        /**
         * Scan and hide empty shortcode containers.
         */
        function hideEmptyContainers() {
            // 1. td_block_text_with_title wrappers
            //    (wraps GETSINGLEPOSTQNA and GETSINGLEPAGEDETAILS)
            document.querySelectorAll('.td_block_text_with_title').forEach(function (block) {
                var inner = block.querySelector('.tdb-block-inner')
                         || block.querySelector('.td-block-span12')
                         || block;

                if (isVisuallyEmpty(inner)) {
                    block.classList.add('hess-empty');
                    block.setAttribute('aria-hidden', 'true');
                } else {
                    block.classList.remove('hess-empty');
                    block.removeAttribute('aria-hidden');
                }
            });

            // 2. tdb_single_tags blocks (tag shortcode)
            document.querySelectorAll('.tdb_single_tags').forEach(function (block) {
                var tagLinks = block.querySelectorAll('a');
                if (tagLinks.length === 0) {
                    block.classList.add('hess-empty');
                    block.setAttribute('aria-hidden', 'true');
                } else {
                    block.classList.remove('hess-empty');
                    block.removeAttribute('aria-hidden');
                }
            });

            // 3. vc_row_inner / vc_column_inner that only contain
            //    hidden children (cascade cleanup)
            document.querySelectorAll('.vc_row_inner').forEach(function (row) {
                var children = row.querySelectorAll('.vc_column_inner');
                var allEmpty = true;

                children.forEach(function (col) {
                    var visibleBlocks = col.querySelectorAll(':scope > *:not(.hess-empty)');
                    if (visibleBlocks.length > 0) {
                        allEmpty = false;
                    }
                });

                if (allEmpty && children.length > 0) {
                    row.classList.add('hess-empty');
                    row.setAttribute('aria-hidden', 'true');
                }
            });
        }

        // Run on DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', hideEmptyContainers);
        } else {
            hideEmptyContainers();
        }

        // Run again after window load (catches lazy-loaded content)
        window.addEventListener('load', hideEmptyContainers);

        // Observe DOM mutations for AJAX / dynamic content
        if (typeof MutationObserver !== 'undefined') {
            var debounceTimer;
            var observer = new MutationObserver(function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(hideEmptyContainers, 300);
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    })();
    </script>
    <?php
}

/**
 * ──────────────────────────────────────────────────────────────
 * 3. PHP shortcode output filter
 *    If GETSINGLEPOSTQNA or GETSINGLEPAGEDETAILS return empty,
 *    strip the wrapping td_block_text_with_title HTML as well.
 * ──────────────────────────────────────────────────────────────
 */
add_filter( 'the_content', 'hess_strip_empty_shortcode_wrappers', 20 );
function hess_strip_empty_shortcode_wrappers( $content ) {
    if ( empty( $content ) ) {
        return $content;
    }

    // Pattern: td_block_text_with_title wrapper whose inner content
    // (after shortcode processing) is only whitespace / empty tags.
    $content = preg_replace_callback(
        '#(<div[^>]*class="[^"]*td_block_text_with_title[^"]*"[^>]*>)(.*?)(</div>\s*</div>)#is',
        function ( $matches ) {
            $inner = $matches[2];
            // Strip HTML tags and whitespace
            $stripped = trim( wp_strip_all_tags( $inner ) );
            if ( $stripped === '' ) {
                // Return an empty hidden div instead
                return '<div class="td_block_text_with_title hess-empty" aria-hidden="true" style="display:none"></div>';
            }
            return $matches[0];
        },
        $content
    );

    return $content;
}

/**
 * ──────────────────────────────────────────────────────────────
 * 4. Filter tdb_single_tags output to hide when no tags exist
 * ──────────────────────────────────────────────────────────────
 */
add_filter( 'the_content', 'hess_hide_empty_tags_block', 21 );
function hess_hide_empty_tags_block( $content ) {
    if ( empty( $content ) ) {
        return $content;
    }

    // If the current post has no tags, hide tdb_single_tags containers
    $post_id = get_the_ID();
    if ( $post_id ) {
        $tags = get_the_tags( $post_id );
        if ( empty( $tags ) ) {
            $content = preg_replace(
                '#<div[^>]*class="[^"]*tdb_single_tags[^"]*"[^>]*>.*?</div>\s*(?:</div>\s*)*#is',
                '<div class="tdb_single_tags hess-empty" aria-hidden="true" style="display:none"></div>',
                $content
            );
        }
    }

    return $content;
}
