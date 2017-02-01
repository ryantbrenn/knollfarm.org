/**
 * Cover stray console calls in browsers that don't support console
 * 
 * @type console
 */
if (!console){
    var console = {
        log   : function(){},
        dir   : function(){},
        warn  : function(){},
        info  : function(){},
        debug : function(){},
        err   : function(){}
    };
}

/**
 * Periscope JS namespace. Use this namespace if adding global
 * variables using wp_localize_script()
 *
 * @type PERISCOPE
 */
var PERISCOPE = PERISCOPE || {};

/**
 * WordPress jQuery Enclosure
 * Works around WordPress' loading jQuery in noConflict
 * Semi-colon is for if/when WordPress supports concatenation
 * of scripts in themes
 *
 * @param {jQuery} $
 * @param {object} APP
 * @returns {void}
 */
;(function($, APP){

    /**
     * DOM Ready function
     * @returns {void}
     */
    $(function(){
        APP.LoadMore.init();
        APP.Filterable.init();
        APP.ScrollAnimations.init();
        APP.PlaceholderShim.init();
        APP.OpenExternal.init();
    }); // close DOM Ready


    /**
     * Add target="_blank" to external urls in post content
     * @type {{init: Function}}
     */
    APP.OpenExternal = {
        init: function() {
            var hostname = window.location.hostname;
            $('.js-open-content-links-externally a').each(function(){
                var $this = $(this);

                if ($this.attr('href').indexOf(hostname) == -1) {
                    $this.attr('target', '_blank');
                }
            });
        }
    };

    /**
     * Load More object
     * @type {{init: Function}}
     */
    APP.LoadMore = {
        $contentContainer : null,
        $btn : null,
        $loadMore : null,
        $msg : null,
        init: function () {
            var $btn = $('#js-btn-loadmore');
            if ($btn.length == 0) {
                return;
            }

            this.$btn = $btn;
            this.$contentContainer = $('#js-loadmore-container');
            this.$loadMore = $('#js-loadmore-status');
            this.$loadMoreMsg = $('#js-loadmore-msg');

            this.$btn.on('click', function (e) {
                e.preventDefault();
                var data = {
                    url: $(this).data('baseurl'),
                    paged: $(this).data('next-page'),
                    max_pages: $(this).data('max-pages')
                };

                APP.LoadMore.doAjax(data);
            });

            $(window).bind('popstate', this.popState.bind(this));
        },

        doAjax : function(data) {
            var self = this;

            $.ajax({
                url : data.url,
                data : data,
                dataType : 'html',
                type : 'GET',
                beforeSend: function() {
                    // show loader gif
                    self.$loadMore.show();
                },
                success: function(content) {
                    var $content = $(content).find('#js-loadmore-container');
                    if ($content.length == 0) {
                        // some message here?
                        return;
                    }

                    self.$contentContainer.append($content.html());
                    self.setHistory(data);

                    if (data.max_pages >= data.paged) {
                        self.$btn.data('next-page', data.paged + 1);
                    }
                },
                error : function(xhr, textStatus, errorThrown) {
                    self.$loadMoreMsg.text('No more posts.');
                    self.$loadMoreMsg.show();
                },
                complete : function() {
                    // hide loader gif
                    self.$loadMore.hide();
                    self.$loadMoreMsg.fadeOut(5000);
                }
            });
        },

        setHistory : function(data) {
            var url = '?paged=' + (data.paged),
                title = window.document.title + ' | Page ' + (data.paged),
                stateObj = {
                    page : data.paged
                };

            history.pushState(stateObj, title, url);
        },

        popState : function(e) {
            var page = 1;

            if (history.state !== null) {
                page = history.state.page;
            }

            this.scrollTo(page);
        },

        scrollTo : function(page) {
            var $scrollToElement = $('#js-page-' + page),
                $wpAdminBar      = $('#wpadminbar'),
                scrollToY        = ($scrollToElement.length !== 0) ? $scrollToElement.position().top : 0,
                adminOffset      = ($wpAdminBar.outerHeight() !== null) ? $wpAdminBar.outerHeight(): 0;

            $('html,body').animate({ scrollTop : (scrollToY - adminOffset) + 'px' }, 1000, 'swing');
        }
    };


    /**
     * Filterable
     *
     * Filter elements based on tagging.
     *
     * @type {{init: Function}}
     */
    APP.Filterable = {
        init: function() {
            var $filterable = $('[data-filtered-by]'),
                hidden_class = 'filterable--hidden';

            $('.keep-open').on("click",function(e) {
                e.stopPropagation();
            });

            $('[data-filter]').on('click', function(event) {
                event.preventDefault();

                var $this = $(this),
                    filter = $this.data('filter');

                // remove selected class from other elements
                $this.parents('ul').find('.selected').removeClass('selected');
                $this.addClass('selected');

                if (filter == '*') {
                    $filterable.removeClass(hidden_class);
                } else {
                    $filterable.each(function(index, element) {
                        var $element = $(element),
                            filters = $element.data('filtered-by');

                        if ($.inArray(filter, filters) == -1) {
                            $element.addClass(hidden_class);
                        } else {
                            $element.removeClass(hidden_class);
                        }
                    });
                }
            });
        }
    }

    APP.ScrollAnimations = {
        init: function() {
            var wow = new WOW({
                    offset:       0,
                    mobile:       true,
                    live:         true
                });
            wow.init();
        }
    }

    APP.PlaceholderShim = {

        init : function() {
            var inputs = document.createElement('input');
            supportsPlaceholder = ('placeholder' in inputs);

            if (!supportsPlaceholder) {
                this.shimIt();
            }
        },

        shimIt : function () {
            // IE9 haphazardly supports jQuery's .load event
            // will only call it about half the number of refreshes
            $('[placeholder]').each(function(){
                var input = $(this);
                if (input.val() == '') {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            });

            $('[placeholder]').on('focus', function(){
                // move the cursor to the beginning of the text field on focus
                $(this).get(0).setSelectionRange(0,0)
            }).on('keypress', function() {
                // clear the text field when typing starts
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                    input.removeClass('placeholder');
                }
            }).on('blur', function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).parents('form').on('submit', function() {
                $(this).find('[placeholder]').each(function() {
                    var input = $(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                })
            });
        }

    };

}(jQuery, PERISCOPE));