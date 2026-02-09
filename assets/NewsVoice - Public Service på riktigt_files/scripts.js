/*================================================================*\

 Name: custom.js
 Author:Nya Dagbladet
 Author URI: https://nyadagbladet.se
 Version: 3.0.0

 \*================================================================*/


 jQuery(function ($) {

    'use strict';


    /*================================================================*\
     ================================================================
     Table Of Contents
     ================================================================
     # Blank JS Wrapper

     \*================================================================*/


    // ================================================================
    // Blank JS Wrapper
    // ================================================================

    (function () {


    }());



    // ================================================================
    // Newsticker
    // ================================================================

    $(function() {
        $('.newsticker').bxSlider({
            mode: 'vertical',
            controls:false,
            auto:'true',
            pager: false,
            speed: 700
        });
    });



    // ================================================================
    // Tabber-widget
    // ================================================================

       (function () {
            $(".tab_content").hide();
            $("ul.tabs li:first").addClass("active").show();
            $(".tab_content:first").show();
            $("ul.tabs li").click(function() {
            $("ul.tabs li").removeClass("active");
            $(this).addClass("active");
            $(".tab_content").hide();
            var activeTab = $(this).find("a").attr("href");
            //$(activeTab).fadeIn();
            $(activeTab).fadeIn();
            return false;
            });

        }());


    //wrap images for scaling effect
    (function () {
        $('.main-section img,.main-section a img').wrap('<div class="image-wrap" />');
    }());

/*    $('.post-thumbnail-col1 a img').click(function (){
        alert('Clicked');
    });*/ 

   

    (function () {
        $( document ).ready(function($){
            $(document).on('click','.elementor-location-popup a', function(event){
                elementorProFrontend.modules.popup.closePopup( {}, event);
            })
        });
    }());


    //wrap iframe for responsive video
    (function () {
        $('iframe#odysee-iframe, .widget iframe').wrap('<div class="wp-embed-aspect-16-9 wp-has-aspect-ratio  content-video"/>');
    }());

    (function () {
        $( document ).ready(function($){
            $('.adv-ads iframe, .nyd-target iframe', '.above-comment-widget iframe').unwrap('<div class="wp-embed-aspect-16-9 wp-has-aspect-ratio  content-video" />');
        });
    }());

    /*$(document).ready(function() {
        function myFunction(){
            alert('This is an alert message.');
        }
        $('.mybtn').click(function(){
            myFunction();
        });
    });*/


});  // end of jquery main wrapper