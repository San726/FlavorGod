jQuery.noConflict();
(function ($) {
    $(document).ready(function () {

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
                $('.toggle-menu').trigger('click');
                e.preventDefault();
            });

            $('.dropdown-toggle').dropdown();
        }
        //]]>


        var ismobiconVisible = $('.navbar-toggle').is(':visible');

        ismobiconVisible = $('.navbar-toggle').is(':visible');
        //console.log(ismobiconVisible);
        if (!ismobiconVisible) {
            if ($('.arrow').length) {
                $('.nav-main .arrow').hide();
                $('.dropdown-menu').removeAttr('style');
            }
            $('#navbar-collapse-main').removeClass('cbp-spmenu-open');
        } else {
            $('.nav-main .dropdown-menu').each(function () {
                if (!$('.arrow').length) {
                    $('<span class="arrow"></span>').insertBefore($(this));
                    $(this).next().hide();
                } else {
                    $('.nav-main .arrow').show();
                }
            });
        }

        $('html').click(function () {
            $('#navbar-collapse-main').removeClass('cbp-spmenu-open');
            $('.dropdown-menu').slideUp();
        });

        $('#navbar-collapse-main').click(function (event) {
            event.stopPropagation();
        });

        $('.menu-close').click(function (e) {
            e.stopPropagation();

            $('.navbar-toggle').removeClass('cbp-spmenu-open');
            $('.dropdown-menu').slideUp();
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
            if (!ismobiconVisible) {
                if ($('.arrow').length) {
                    $('.nav-main .arrow').hide();
                    $('.dropdown-menu').removeAttr('style');
                }
                $('#navbar-collapse-main').removeClass('cbp-spmenu-open');
            } else {

                $('.nav-main .dropdown-menu').each(function () {
                    if (!$('.arrow').length) {
                        $('<span class="arrow"></span>').insertBefore($(this));
                        $(this).next().hide();
                        bindClick();
                    } else {
                        $('.nav-main .arrow').show();
                    }
                });


            }
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
            $(this).find('img').addClass('bannerimage');
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
        //For Slider
        if ($('.owlslider').length > 0) {
            $('.owlslider').owlCarousel({
                autoplay: true,
                items: 1,
                nav: false,
                dots: true,
                //pagination: true,
                navText: "",
                loop: true,
                responsiveClass: true,
                smartSpeed: 1300,
                responsive: {
                    320: {
                        items: 1
                    },
                    480: {
                        items: 1
                    },
                    767: {
                        items: 1
                    },
                    1092: {
                        items: 1
                    }
                }
            });
        }

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


    $(".zoom-lightbox").each(function () {
        var gallaryArray = [];
        $(this).prev().find(".gallery-item").each(function () {
            var imageUrl = $(this).attr("src");
            gallaryArray.push({
                "src": imageUrl
            });
        });
        var gallaryLength = gallaryArray.length;
        $(this).magnificPopup({
            items: gallaryArray,
            mainClass: 'my-mfp-slide-bottom',
            gallery: {
                enabled: true
            },
            type: 'image',
            callbacks: {
                beforeOpen: function () {
                    var magnificPopup = $.magnificPopup.instance;
                    if (gallaryLength <= $(".owl-item.active").index() - 2) {
                        magnificPopup.goTo(0);
                    } else {
                        magnificPopup.goTo($(".owl-item.active").index() - 2);
                    }
                }
            }
        });
    });

    $(".product-slider").each(function () {
        var $sync1 = $(this).find(".sync1");
        var $sync2 = $(this).find(".sync2");
        var flag = false,
                duration = 300;

        $sync1.owlCarousel({
            items: 1,
            nav: false,
            dots: false,
            loop: true,
            autoplay: true,
            /*afterAction: afterAction,*/
            afterInit: function () {
                //$('#sync2 .owl-stage-outer .owl-stage .owl-item').eq(e.item.index).addClass('activee')
            }
        });

        $sync1.on('translated.owl.carousel', function (e) {
            var finalindex;
            if (e.item.index - 2 >= e.item.count) {
                finalindex = 0;
            } else {
                finalindex = e.item.index - 2;
            }
            $sync2.find(".owl-item").removeClass("activee");
            $sync2.find(".owl-item").eq(finalindex).addClass('activee');
            $sync2.trigger('to.owl.carousel', [finalindex, duration, true]);

            /*$('.sync2 .owl-stage-outer .owl-stage .owl-item').removeClass('') */
            /*$('.sync2 .owl-stage-outer .owl-stage .owl-item').eq(e.item.index).addClass('activee')*/
            /*if (e.namespace && e.property.name === 'items' && !flag) {
             flag = true;
             $sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
             console.log(e.item.index);
             flag = false;
             }*/
        });

        $sync2.owlCarousel({
            items: 3,
            margin: 30,
            nav: false,
            center: false,
            dots: false,
            autoplay: false,
            responsive: {
                0: {
                    items: 2,
                    margin: 10
                },
                480: {
                    items: 3,
                    margin: 10
                },
                640: {
                    items: 3,
                    margin: 15
                },
                768: {
                    items: 3,
                    margin: 10
                },
                992: {
                    items: 3,
                    margin: 20
                },
                1200: {
                    items: 3,
                    margin: 30
                }
            },
            afterInit: function (e) {
                /*console.log("not working");
                 console.log(e.item.index);
                 $('.sync2 .owl-stage-outer .owl-stage .owl-item').eq(e.item.index).addClass('activee')*/
            }
        });

        $sync2.on('click', '.owl-item', function () {
            $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
        });

        $sync2.on('change.owl.carousel', function (e) {
            if (e.namespace && e.property.name === 'items' && !flag) {
                flag = true;
                $sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                flag = false;
            }
        });
        $sync2.find(".owl-item").eq(0).addClass("activee");
    });



    $("#owl-demo1").owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        loop: true,
        autoplay: true,
        smartSpeed: 4000
    });

    // [IE Detector]
    if (window.ActiveXObject || "ActiveXObject" in window) {  // IE Detector
        $('body').addClass('ie-browser');
    }

    // [Placeholder for IE9]
    if ($('input').length > 0) {
        jQuery('input').placeholder();
    }


    // [Page loader]
    $(window).load(function () {
        setTimeout(function () {
            $('body').removeClass("loading").addClass('loaded');
            $('.site-loader').fadeOut(600);
        }, 500);
    });
})(jQuery);
