
var App = function() {
    
    "use strict";

    // IE mode
    var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;
    var responsiveHandlers = [];
       
    var sidebarWidth = '250px';
    
    // this function handles responsive layout on screen size resize or mobile device rotate.
    var handleResponsive = function() {
        var isIE8 = (navigator.userAgent.match(/msie [8]/i));
        var isIE9 = (navigator.userAgent.match(/msie [9]/i));
        var isIE10 = !!navigator.userAgent.match(/MSIE 10/);

        if (isIE10) {
            $('html').addClass('ie10'); // detect IE10 version
        }

        $('.navbar li.nav-toggle').click(function() {
            $('body').toggleClass('nav-open');
        });

        /**
         * Sidebar-Toggle-Button
         */

        $('.toggle-sidebar').click(function(e) {
            e.preventDefault();

            // Reset manual divider-resize
            $('#sidebar').css('width', '');
            $('#sidebar > #divider').css('margin-left', '');
            $('#content').css('margin-left', '');

            // Toggle class
            $('#container').toggleClass('sidebar-closed');
        });

        /**
         * Top-Left-Menu-Toggle-Button
         */

        $('.toggle-top-left-menu').click(function(e) {
            e.preventDefault();

            // Toggle visibility
            $('.navbar-left.navbar-left-responsive').slideToggle(200);
        });

        var handleElements = function() {
            // First visible childs add .first
            $('.crumbs .crumb-buttons > li').removeClass('first');
            $('.crumbs .crumb-buttons > li:visible:first').addClass('first');

            // Remove phone-navigation
            if ($('body').hasClass('nav-open')) {
                $('body').toggleClass('nav-open');
            }

            // Set default visibility state
            $('.navbar-left.navbar-left-responsive').removeAttr('style');

            // Add additional scrollbars
            handleScrollbars();

            // Handle project switcher width
            //handleProjectSwitcherWidth();
        }

        // handles responsive breakpoints.
        $(window).setBreakpoints({
            breakpoints: [320, 480, 768, 979, 1200]
        });

        $(window).bind('exitBreakpoint320', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint320', function() {
            handleElements();

            resetResizeableSidebar();
        });

        $(window).bind('exitBreakpoint480', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint480', function() {
            handleElements();

            resetResizeableSidebar();
        });

        $(window).bind('exitBreakpoint768', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint768', function() {
            handleElements();

            resetResizeableSidebar();
        });

        $(window).bind('exitBreakpoint979', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint979', function() {
            handleElements();
        });

        $(window).bind('exitBreakpoint1200', function() {
            handleElements();
        });
        $(window).bind('enterBreakpoint1200', function() {
            handleElements();
        });
    }
    
    var calculateHeight = function() {
        $('body').height('100%');

        var $header = $('.header');
        var header_height = $header.outerHeight();

        var document_height = $(document).height();
        var window_height = $(window).height();

        var doc_win_diff = document_height - window_height;

        if (doc_win_diff <= header_height) {
            var new_height = document_height - doc_win_diff;
        } else {
            var new_height = document_height;
        }

        new_height = new_height - header_height;

        var document_height = $(document).height();

        $('body').height(new_height);
    }
    
    var handleLayout = function() {
        calculateHeight();

        // For margin to top, if header is fixed
        if ($('.header').hasClass('navbar-fixed-top')) {
            $('#container').addClass('fixed-header');
        }
    }
    
    var handleResizeEvents = function() {
        var resizeLayout = debounce(_resizeEvents, 30);
        $(window).resize(resizeLayout);
    }

    // Executed only every 30ms
    var _resizeEvents = function() {
        calculateHeight();

        // Realign headers from DataTables (otherwise header will have an offset)
        // Only affects horizontal scrolling DataTables
        if ($.fn.dataTable) {
            var tables = $.fn.dataTable.fnTables(true);
            $(tables).each(function() {
                if (typeof $(this).data('horizontalWidth') != 'undefined') {
                    $(this).dataTable().fnAdjustColumnSizing();
                }
            });
        }
    }
    
    /**
     * Creates and returns a new debounced version of the passed
     * function which will postpone its execution until after wait
     * milliseconds have elapsed since the last time it was invoked.
     *
     * Source: http://underscorejs.org/
     */
    var debounce = function(func, wait, immediate) {
        var timeout, args, context, timestamp, result;
        return function() {
            context = this;
            args = arguments;
            timestamp = new Date();
            var later = function() {
                var last = (new Date()) - timestamp;
                if (last < wait) {
                    timeout = setTimeout(later, wait - last);
                } else {
                    timeout = null;
                    if (!immediate)
                        result = func.apply(context, args);
                }
            };
            var callNow = immediate && !timeout;
            if (!timeout) {
                timeout = setTimeout(later, wait);
            }
            if (callNow)
                result = func.apply(context, args);
            return result;
        };
    };

    /**
     * Swipe Events
     */
    var handleSwipeEvents = function() {
        // Enable feature only on small widths
        if ($(window).width() <= 767) {

            $('body').on('movestart', function(e) {
                // If the movestart is heading off in an upwards or downwards
                // direction, prevent it so that the browser scrolls normally.
                if ((e.distX > e.distY && e.distX < -e.distY) || (e.distX < e.distY && e.distX > -e.distY)) {
                    e.preventDefault();
                }

                // Prevents showing sidebar while scrolling through projects
                var $parentClass = $(e.target).parents('#project-switcher');

                if ($parentClass.length) {
                    e.preventDefault();
                }
            }).on('swipeleft', function(e) {
                // Hide sidebar on swipeleft
                $('body').toggleClass('nav-open');
            }).on('swiperight', function(e) {
                // Show sidebar on swiperight
                $('body').toggleClass('nav-open');
            });

        }
    }

    var handleSidebarMenu = function() {
        var arrow_class_open = 'fa fa-angle-up',
                arrow_class_closed = 'fa fa-angle-down';

        $('li:has(ul)', '#sidebar-content ul').each(function() {
            if ($(this).hasClass('current') || $(this).hasClass('open-default')) {
                $('>a', this).append("<i class='arrow " + arrow_class_open + "'></i>");
            } else {
                $('>a', this).append("<i class='arrow " + arrow_class_closed + "'></i>");
            }
        });

        if ($('#sidebar').hasClass('sidebar-fixed')) {
            $('#sidebar-content').append('<div class="fill-nav-space"></div>');
        }

        $('#sidebar-content ul > li > a').on('click', function(e) {

            if ($(this).next().hasClass('sub-menu') == false) {
                return;
            }

            // Toggle on small devices instead of accordion
            if ($(window).width() > 767) {
                var parent = $(this).parent().parent();

                parent.children('li.open').children('a').children('i.arrow').removeClass(arrow_class_open).addClass(arrow_class_closed);
                parent.children('li.open').children('.sub-menu').slideUp(200);
                parent.children('li.open-default').children('.sub-menu').slideUp(200);
                parent.children('li.open').removeClass('open').removeClass('open-default');
            }

            var sub = $(this).next();
            if (sub.is(":visible")) {
                $('i.arrow', $(this)).removeClass(arrow_class_open).addClass(arrow_class_closed);
                $(this).parent().removeClass('open');
                sub.slideUp(200, function() {
                    $(this).parent().removeClass('open-fixed').removeClass('open-default');
                    calculateHeight();
                });
            } else {
                $('i.arrow', $(this)).removeClass(arrow_class_closed).addClass(arrow_class_open);
                $(this).parent().addClass('open');
                sub.slideDown(200, function() {
                    calculateHeight();
                });
            }

            e.preventDefault();
        });

        var _handleResizeable = function() {
            $('#divider.resizeable').mousedown(function(e) {
                e.preventDefault();

                var divider_width = $('#divider').width();
                $(document).mousemove(function(e) {
                    var sidebar_width = e.pageX + divider_width;
                    if (sidebar_width <= 300 && sidebar_width >= (divider_width * 2 - 3)) {
                        if (sidebar_width >= 240 && sidebar_width <= 260) {
                            $('#sidebar').css("width", 250);
                            $('#sidebar-content').css("width", 250);
                            $('#content').css("margin-left", 250);
                            $('#divider').css("margin-left", 250);
                        } else {
                            $('#sidebar').css("width", sidebar_width);
                            $('#sidebar-content').css("width", sidebar_width);
                            $('#content').css("margin-left", sidebar_width);
                            $('#divider').css("margin-left", sidebar_width);
                        }

                    }

                })
            });
            $(document).mouseup(function(e) {
                $(document).unbind('mousemove');
            });
        }

        _handleResizeable();
    }

    /**
     * Removes the CSS-styles added with jQuery while resizing the sidebar
     */
    var resetResizeableSidebar = function() {
        $('#sidebar').css("width", "");
        $('#sidebar-content').css("width", "");
        $('#content').css("margin-left", "");
        $('#divider').css("margin-left", "");
    }
    
    var handleScrollbars = function() {
        var android_chrome = /android.*chrom(e|ium)/.test(navigator.userAgent.toLowerCase());

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && android_chrome == false) {
            $('#sidebar').css('overflow-y', 'auto');
        } else {
            if ($('#sidebar').hasClass('sidebar-fixed') || $(window).width() <= 767) {

                // Since Chrome on Android has problems with scrolling only in sidebar,
                // this is a workaround for this
                //
                // Awaiting update from Google

                if (android_chrome && !$('#sidebar').hasClass('sidebar-fixed-responsive')) {
                    var wheelStepInt = 100;
                    $('#sidebar').attr('style', 'position: absolute !important;');

                    // Fix for really high tablet resolutions
                    if ($(window).width() > 979) {
                        $('#sidebar').css('margin-top', '-52px');
                    }

                    // Only hide sidebar on phones
                    if ($(window).width() <= 767) {
                        $('#sidebar').css('margin-left', '-250px').css('margin-top', '-52px');
                    }
                } else {
                    var wheelStepInt = 7;

                    $('#sidebar-content').slimscroll({
                        position: 'left',
                        'height': '100%',
                        wheelStep: wheelStepInt
                    });
                }
            }
        }
    }
    
    
    
   
    
    var handelTooltip = function () {        
        if (App.isTouchDevice()) { // if touch device, some tooltips can be skipped in order to not conflict with click events
            jQuery('.bs-tooltip:not(.no-tooltip-on-touch-device)').tooltip();
        } else {
            jQuery('.bs-tooltip').tooltip();
        }
                
    };        //  function to Handel Bootstrap Tooltip
    
    var handelPopovers = function() {
       jQuery('.popovers').popover();
    }         //  Function to handel  Popovers
        
    var handlePortletTools = function () {
        jQuery('.portlet .tools a.remove').click(function () {
            var removable = jQuery(this).parents(".portlet");
            if (removable.next().hasClass('portlet') || removable.prev().hasClass('portlet')) {
                jQuery(this).parents(".portlet").remove();
            } else {
                jQuery(this).parents(".portlet").parent().remove();
            }
        });

        jQuery('.portlet .tools a.reload').click(function () {
            var el = jQuery(this).parents(".portlet");
            App.blockUI(el);
            window.setTimeout(function () {
                App.unblockUI(el);
            }, 1000);
        });

        jQuery('.portlet .tools .collapse, .portlet .tools .expand').click(function () {
            var el = jQuery(this).parents(".portlet").children(".portlet-body");
            if (jQuery(this).hasClass("collapse")) {
                jQuery(this).removeClass("collapse").addClass("expand");
                el.slideUp(200);
            } else {
                jQuery(this).removeClass("expand").addClass("collapse");
                el.slideDown(200);
            }
        });

    };   // function to Handel Portlet Tools   
        
    var handelSlimScroll = function() {
        $(".scroller").each(function() {
            $(this).slimScroll({
                size: "7px",
                opacity: "0.6",
                position: "right",
                height: $(this).attr("data-height"),
                alwaysVisible: ($(this).attr("data-always-visible") == "1" ? true : false),
                railVisible: ($(this).attr("data-rail-visible") == "1" ? true : false),
                disableFadeOut: true
            })
        })
    };      // function to Handel Slim Scroll
    
    var handelSelect2 = function() {
        
        if (!jQuery().select2) {
            return;
        }
        
        $('.select2').select2({minimumResultsForSearch: -1 });
        $('.select2Search').select2();
    };         //  Function to handel  Sclect2
    
    var handleScrollTop = function () {
         $(window).scroll(function() {
            if ($(this).scrollTop() > 200) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });

        $('.scrollup').click(function() {
            $("html, body").animate({scrollTop: 0}, 600);
            return false;
        });
    };      //  Function to handle ScrollTop
    
    var handelCheckbox = function () {
        if (!jQuery().iCheck) {
            return;
        }
        
        $('input').iCheck({
            checkboxClass: 'icheckbox_minimal',
            radioClass: 'iradio_minimal'
        });
    };      //  Function to handel Checkbox
    
    var handleTypeHead = function () {
        if (!jQuery().typeahead) {
            return;
        }
       
        $('.typeahead').typeahead({
            name: 'programming',
            local: [
                "Java",
                "dot net",
                "c#",
                "Visual Basic",
                "Json",
                "php",
                "c",
                "jsp",
                "html",
                "jQuery",
                "java script",
                "css",
                "node",
                "bootstrap",
                "pascal",
                "portan",
                "servelet",
                "asp"
            ],
            limit: 10
        });
    };      //  Function to handle TypeHead
    
    var handleDatepicker = function () {
        if (!jQuery().datepicker) {
            return;
        }
       $('.datepicker').datepicker();
    };      //  Function to handle Datepicker
    
    var handleTimePicker = function () {
        if (!jQuery().timepicker) {
            return;
        }
       $('.timepicker').timepicker();
    };      //  Function to handle TimePicker
    
       
    var handleLoginForm = function () {

       jQuery('#forget-password').click(function () {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

        jQuery('#register-btn').click(function () {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function () {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    }       //  Function to handle LoginForm
    
    
    
    
       
    return {        
        init: function() {
            //core handlers
            handleResponsive(); // Checks for IE-version, click-handler for sidebar-toggle-button, Breakpoints
            handleLayout(); // Calls calculateHeight()
            handleResizeEvents(); // Calls _resizeEvents() every 30ms on resizing
            handleSwipeEvents(); // Enables feature to swipe to the left or right on mobile phones to open the sidebar
            handleSidebarMenu(); // Handles navigation
            handleScrollbars(); // Adds styled scrollbars for sidebar on desktops

            handleScrollTop();
            handelTooltip();
            handelPopovers();
            handlePortletTools();
            handelSlimScroll();
            handelSelect2();
            handleTypeHead();
            handleDatepicker();
            handleTimePicker();
            handelCheckbox();
            
        },
                
        // login page setup
        initLogin: function () {
            handleLoginForm(); // handles login form
        },
                
        // wrapper function to  block element(indicate loading)
        blockUI: function (el, centerY) {
            var el = jQuery(el); 
            el.block({
                    message: '<img src="./assets/images/preload.GIF" align="">',
                    centerY: centerY != undefined ? centerY : true,
                    css: {
                        top: '10%',
                        border: 'none',
                        padding: '2px',
                        backgroundColor: 'none'
                    },
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.05,
                        cursor: 'wait'
                    }
                });
        },
                
        // wrapper function to  un-block element(finish loading)
        unblockUI: function (el) {
            jQuery(el).unblock({
                    onUnblock: function () {
                        jQuery(el).removeAttr("style");
                    }
                });
        },  
                
        isTouchDevice: function () {
            try {
                document.createEvent("TouchEvent");
                return true;
            } catch (e) {
                return false;
            }
        }
    };
}();