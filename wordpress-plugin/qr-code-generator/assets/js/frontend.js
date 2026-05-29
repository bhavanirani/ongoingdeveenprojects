(function($) {
    'use strict';

    $(document).ready(function() {
        // Type selection
        $(document).on('click', '.qcg-type-btn', function() {
            $('.qcg-type-btn').removeClass('active');
            $(this).addClass('active');

            var type = $(this).data('type');
            $('#qcg_url_type').val(type);

            $('.qcg-section').removeClass('active');
            $('#qcg-section-' + type).addClass('active');
        });

        // Generate QR code
        $(document).on('click', '.qcg-btn-generate', function(e) {
            e.preventDefault();

            var $btn = $(this);
            var $form = $btn.closest('.qcg-form');
            var $preview = $form.closest('.qcg-wrap, .qcg-frontend-wrap').find('.qcg-preview');
            var $loading = $preview.find('.qcg-loading');
            var $result = $preview.find('.qcg-result');
            var $error = $form.find('.qcg-error');

            $error.hide();
            $result.hide();
            $loading.show();
            $btn.prop('disabled', true);

            var formData = $form.find(':input').serialize();
            formData += '&action=qcg_generate&nonce=' + qcg_ajax.nonce;

            $.ajax({
                url: qcg_ajax.ajax_url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    $loading.hide();
                    $btn.prop('disabled', false);

                    if (response.success) {
                        $result.find('.qcg-qr-image').attr('src', response.data.qr_image);
                        $result.find('.qcg-url-display').text(
                            response.data.content.length > 80
                                ? response.data.content.substring(0, 80) + '...'
                                : response.data.content
                        );
                        $result.show();
                    } else {
                        $error.text(response.data.message || 'An error occurred.').show();
                    }
                },
                error: function() {
                    $loading.hide();
                    $btn.prop('disabled', false);
                    $error.text('Network error. Please try again.').show();
                }
            });
        });

        // Download QR code
        $(document).on('click', '.qcg-btn-download', function(e) {
            e.preventDefault();

            var $wrap = $(this).closest('.qcg-wrap, .qcg-frontend-wrap');
            var $form = $wrap.find('.qcg-form');

            var formData = $form.find(':input').serialize();
            formData += '&action=qcg_download&nonce=' + qcg_ajax.nonce;

            $.ajax({
                url: qcg_ajax.ajax_url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        var blob = new Blob(
                            [atob(response.data.svg_data)],
                            { type: 'image/svg+xml' }
                        );
                        var url = URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = response.data.filename;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        URL.revokeObjectURL(url);
                    }
                }
            });
        });
    });
})(jQuery);
