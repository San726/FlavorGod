// jQuery.noConflict();
(function (window) {
    var jQuery = window.jQuery || window.$ || {};
    var $ = jQuery;
    // var document = window.document;

    $(document).ready(function () {

        $(".chk-all input[type='checkbox']").each(function () {
            if ($(this).is(':checked')) {
                //console.log($(this).closest("li").find("input[type='checkbox']"));
                $(this).closest("ul").find(".checkbox").each(function () {
                    console.log($(this));
                    $(this).find("input[type='checkbox']").attr('checked', true);
                });
            }
        })

        $(".custom-option input[type='checkbox']").on("change", function () {
            if ($(this).closest(".chk-all").length) {
                if ($(this).is(':checked')) {
                    $(this).closest("ul").find(".checkbox").each(function () {
                        $(this).find("input[type='checkbox']").prop('checked', true);
                    });
                } else {
                    $(this).closest("ul").find(".checkbox").each(function () {
                        $(this).find("input[type='checkbox']").prop('checked', false);
                    });
                }
            } else {
                if ($(this).is(':checked')) {
                } else {
                    $(this).closest("ul").find(".chk-all input[type='checkbox']").prop('checked', false);
                }
            }
        });


        if ($(".item-video a").length > 0) {

            $(".item-video a").magnificPopup({
                type: 'iframe',
                iframe: {
                    markup: '<div class="mfp-iframe-scaler">' +
                            '<div class="mfp-close"></div>' +
                            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                            '<div class="mfp-title">Some caption</div>' +
                            '</div>'
                },
                callbacks: {
                    markupParse: function (template, values, item) {
                        values.title = item.el.attr('title');
                    }
                }
            });
        }


        $(".custom-option-header").on('click', function (e) {
            e.stopPropagation();
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this).next(".custom-option-content").stop(true, true).slideUp();
            } else {
                $(".custom-option-header").removeClass("active");
                $(".custom-option-content").stop(true, true).slideUp();
                $(this).addClass("active");
                $(this).next(".custom-option-content").stop(true, true).slideDown();
            }
        });


        $(".custom-option-content").on('click', function (e) {
            e.stopPropagation();
        })


        // [Display after load completed]
        $('.lazyload').addClass('loaded');

        $('.navbar-nav.nav-main').addClass('shown');

        // [close self modal if opening other modal]
        $('.modal [data-toggle="modal"]').click(function () {
            $(this).parents('.modal').modal('hide');
        });

        //For Menu Responsive
        /*
         $(document).on('click', function () {
         if ($(window).width() < 768) {
         //$('.collapse').collapse('hide');
         }
         });
         */

        // [Mobile Menu]
        //<![CDATA[
        if ($('.toggle-menu').length > 0) {
            var pushMenu = $('.toggle-menu').jPushMenu({
                closeOnClickLink: true
            });

            $('.menu-close').on('click touchstart', function (e) {
                e.preventDefault();
            });
            $('.menu-close-cart').on('click touchstart', function (e) {
                //e.preventDefault();
            });


            $(".menu-left").click(function () {
                $('#navbar-collapse-cart').removeClass('cbp-spmenu-open');
            });

            $(".menu-right").click(function () {
                $("#navbar-collapse-main").removeClass("cbp-spmenu-open");
            });

            $('.dropdown-toggle').dropdown();
        }
        //]]>


        var ismobiconVisible = $('.navbar-toggle').is(':visible');

        ismobiconVisible = $('.navbar-toggle').is(':visible');
        //console.log(ismobiconVisible);


        $('html').click(function () {
            $(".custom-option-header").removeClass("active")
            $(".custom-option-content").stop(true, true).slideUp();
            $('#navbar-collapse-main, #navbar-collapse-cart').removeClass('cbp-spmenu-open');
        });

        $('#navbar-collapse-main, #navbar-collapse-cart').click(function (event) {
            event.stopPropagation();
        });

        var menuobj = $('.navbar-nav');
        bindClick();

        function bindClick() {
            menuobj.find('.arrow').on('touchstart click', function (e) {

                var agentID = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                if (agentID) {
                    if ($(this).hasClass('oneclicked')) {
                        e.preventDefault();
                        $(this).next().slideToggle();
                        $(this).toggleClass('up');

                    } else {

                        $(this).addClass('oneclicked');
                    }
                    // mobile code here

                } else {

                    $(this).next().slideToggle();
                    $(this).toggleClass('up');
                }
            });
        }

        $(window).resize(function () {
            ismobiconVisible = $('.navbar-toggle').is(':visible');
            //console.log(ismobiconVisible);
        });


        // [Bootstrap dropdown hover]

        $('ul.nav li.dropdown').hover(function () {
            if ($(window).width() > 767) {
                $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(100);
                //$(this).find('.dropdown-menu').dropdown('toggle');
            }
        }, function () {
            if ($(window).width() > 767) {
                $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(100);
                //$(this).find('.dropdown-menu').dropdown('toggle');
            }
        });


        //banner image
        $('.banner li').each(function () {
            // $(this).find('img').addClass('bannerimage');
            var imgSrc = $(this).find('.bannerimage').attr('src');
            imgSrc = "url(" + imgSrc + ")";
            $(this).css("background-image", imgSrc);
        });
        //inner banner
        $('.inner-banner').each(function () {
            $(this).find('img').addClass('innerbannerimage');
            var imgSrc = $(this).find('.innerbannerimage').attr('src');
            imgSrc = "url(" + imgSrc + ")";
            $(this).css("background-image", imgSrc);
        });


        if ($(".youtube-vieo-btn").length > 0) {
            $(".youtube-vieo-btn").click(function (e) {
                e.preventDefault();
                $(this).parent().find(".iframe-video").show();
                $(this).parents().find(".youtube-video a.fa-close").show();
                $(this).parent().find(".iframe-video iframe")[0].src = $(this).parent().find(".iframe-video iframe")[0].src + "?rel=0&amp;autoplay=1";
                $(".youtube-video a.fa-close").click(function (e) {
                    e.preventDefault();
                    $(this).parents().find(".iframe-video, .youtube-video a.fa-close").hide();
                    var stopvidesrc = $(this).parents('.youtube-video').find(".iframe-video iframe")[0].src;
                    stopvidesrc = stopvidesrc.split('?')[0];
                    $(this).parents('.youtube-video').find(".iframe-video iframe")[0].src = stopvidesrc;
                });
            });
        }
    });

    $(function () {
        function reposition() {
            var modal = $(this),
                    dialog = modal.find('.modal-dialog');
            modal.css('display', 'block');

            // Dividing by two centers the modal exactly, but dividing by three
            // or four works better for larger screens.
            dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
        }
        // Reposition when a modal is shown

        $('.modal').on('show.bs.modal', reposition);
        // Reposition when the window is resized
        $(window).on('resize', function () {
            $('.modal:visible').each(reposition);
        });
    });






    // [IE Detector]
    if (window.ActiveXObject || "ActiveXObject" in window) { // IE Detector
        $('body').addClass('ie-browser');
    }

    // [Placeholder for IE9]
    if ($('input').length > 0) {
        jQuery('input').placeholder();
    }

    // [Page loader]
    $('body').removeClass("loading").addClass('loaded');
    $('.site-loader').hide();
    $(window).load(function () {
        // $('.item-product').eq(0).removeClass('inactive');
        // $('.item-product').not(':first').addClass('inactive');

        // setTimeout(function () {
        //     $('body').removeClass("loading").addClass('loaded');
        //     $('.site-loader').fadeOut(600);
        // }, 500);
    });


    //Decreasing header height after scroll
	$(window).on("scroll", function () {
	    if (!$('body').hasClass('product')){
	        if ($(this).scrollTop() > 5) {
	        $("body").addClass("slimmer");
    	    }
    	    else {
    	        $("body").removeClass("slimmer");
    	    }
	    }
	});
})(window);
