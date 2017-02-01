var PERISCOPE = PERISCOPE || {};

(function ($, APP){
    $(function () {
        // Submit the form saving a draft or an autosave, and show a preview in a new tab
        // Cloned from core/wp-admin/js/post.js line 291
        $('.display-module-preview').on( 'click', function( event ) {

            var $this = $(this),
                $form = $('form#post'),
                $previewField = $('input#wp-preview'),
                $previewInPage = $('input#preview-in-page'),
                target = $this.attr('target') || 'wp-preview',
                ua = navigator.userAgent.toLowerCase();

            event.preventDefault();

            if ( $this.hasClass('disabled') ) {
                return;
            }

            if ( wp.autosave ) {
                wp.autosave.server.tempBlockSave();
            }

            $previewField.val('dopreview');
            $previewInPage.val( $this.data('pageId') );
            $form.attr( 'target', target ).submit().attr( 'target', '' );

            // Workaround for WebKit bug preventing a form submitting twice to the same action.
            // https://bugs.webkit.org/show_bug.cgi?id=28633
            if ( ua.indexOf('safari') !== -1 && ua.indexOf('chrome') === -1 ) {
                $form.attr( 'action', function( index, value ) {
                    return value + '?t=' + ( new Date() ).getTime();
                });
            }

            $previewField.val('');
        });
    });
})(jQuery, PERISCOPE);