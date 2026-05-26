<?php
/**
 * ──────────────────────────────────────────────────────────────
 * ALTERNATIVE: Add this snippet to your theme's functions.php
 * instead of installing the plugin.
 *
 * Paste everything below into:
 *   wp-content/themes/YOUR-THEME/functions.php
 * ──────────────────────────────────────────────────────────────
 */

/**
 * Hide empty shortcode containers — inline CSS
 */
add_action( 'wp_head', function () {
    ?>
    <style id="hide-empty-shortcode-spaces">
        .td_block_text_with_title.hess-empty,
        .tdb_single_tags.hess-empty,
        .hess-empty {
            display: none !important;
            margin: 0 !important;
            padding: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }
    </style>
    <?php
});

/**
 * Hide empty shortcode containers — inline JS
 */
add_action( 'wp_footer', function () {
    ?>
    <script>
    (function () {
        function isVisuallyEmpty(el) {
            if (!el) return true;
            if (el.querySelector('img, iframe, video, embed, object, canvas, svg')) return false;
            return (el.textContent || '').replace(/\s+/g, '').trim().length === 0;
        }

        function hideEmptyContainers() {
            document.querySelectorAll('.td_block_text_with_title').forEach(function (block) {
                var inner = block.querySelector('.tdb-block-inner') || block.querySelector('.td-block-span12') || block;
                if (isVisuallyEmpty(inner)) {
                    block.classList.add('hess-empty');
                    block.setAttribute('aria-hidden', 'true');
                } else {
                    block.classList.remove('hess-empty');
                    block.removeAttribute('aria-hidden');
                }
            });

            document.querySelectorAll('.tdb_single_tags').forEach(function (block) {
                if (block.querySelectorAll('a').length === 0) {
                    block.classList.add('hess-empty');
                    block.setAttribute('aria-hidden', 'true');
                } else {
                    block.classList.remove('hess-empty');
                    block.removeAttribute('aria-hidden');
                }
            });

            document.querySelectorAll('.vc_row_inner').forEach(function (row) {
                var cols = row.querySelectorAll('.vc_column_inner');
                var allEmpty = true;
                cols.forEach(function (col) {
                    if (col.querySelectorAll(':scope > *:not(.hess-empty)').length > 0) allEmpty = false;
                });
                if (allEmpty && cols.length > 0) {
                    row.classList.add('hess-empty');
                    row.setAttribute('aria-hidden', 'true');
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', hideEmptyContainers);
        } else {
            hideEmptyContainers();
        }
        window.addEventListener('load', hideEmptyContainers);

        if (typeof MutationObserver !== 'undefined') {
            var t;
            new MutationObserver(function () {
                clearTimeout(t);
                t = setTimeout(hideEmptyContainers, 300);
            }).observe(document.body, { childList: true, subtree: true });
        }
    })();
    </script>
    <?php
}, 100);

/**
 * Strip empty td_block_text_with_title wrappers (server-side)
 */
add_filter( 'the_content', function ( $content ) {
    if ( empty( $content ) ) return $content;

    $content = preg_replace_callback(
        '#(<div[^>]*class="[^"]*td_block_text_with_title[^"]*"[^>]*>)(.*?)(</div>\s*</div>)#is',
        function ( $m ) {
            if ( trim( wp_strip_all_tags( $m[2] ) ) === '' ) {
                return '<div class="td_block_text_with_title hess-empty" aria-hidden="true" style="display:none"></div>';
            }
            return $m[0];
        },
        $content
    );

    return $content;
}, 20);

/**
 * Hide tdb_single_tags when post has no tags (server-side)
 */
add_filter( 'the_content', function ( $content ) {
    if ( empty( $content ) ) return $content;

    $post_id = get_the_ID();
    if ( $post_id && empty( get_the_tags( $post_id ) ) ) {
        $content = preg_replace(
            '#<div[^>]*class="[^"]*tdb_single_tags[^"]*"[^>]*>.*?</div>\s*(?:</div>\s*)*#is',
            '<div class="tdb_single_tags hess-empty" aria-hidden="true" style="display:none"></div>',
            $content
        );
    }

    return $content;
}, 21);
