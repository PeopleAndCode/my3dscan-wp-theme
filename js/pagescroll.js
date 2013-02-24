jQuery(function() {
    jQuery('#banner a').bind('click',function(event){
        var jQueryanchor = jQuery(this);
        var scrollToPosition = parseInt(jQuery(jQueryanchor.attr('href')).offset().top);
        jQuery('html, body').stop().animate({
            scrollTop: scrollToPosition
        }, 1500,'easeInOutExpo');
        event.preventDefault();
    });

    jQuery('footer ul a').bind('click',function(event){
        var jQueryanchor = jQuery(this);
        var scrollToPosition = parseInt(jQuery(jQueryanchor.attr('href')).offset().top);
        jQuery('html, body').stop().animate({
            scrollTop: scrollToPosition
        }, 1500,'easeInOutExpo');
        event.preventDefault();
    });

    jQuery('.btn-scroll').bind('click',function(event){
        var jQueryanchor = jQuery(this);
        var scrollToPosition = parseInt(jQuery(jQueryanchor.attr('href')).offset().top);
        jQuery('html, body').stop().animate({
            scrollTop: scrollToPosition
        }, 1500,'easeInOutExpo');
        event.preventDefault();
    });
});
