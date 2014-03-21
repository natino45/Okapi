jQuery(".user-info").click(function () {
    if (!jQuery(this).hasClass("user-active")) {
        console.log("no class");
        var b = jQuery(this);
        var a = jQuery(".user-dropbox");
        a.slideDown("fast");
        b.addClass("user-active")
    } else {
        console.log("has class");
        jQuery(this).removeClass("user-active");
        jQuery(".user-dropbox").hide()
    }
    jQuery(".notification-counter").removeClass("notification-active");
    jQuery(".notification-box").hide();
    return false
});
jQuery(".notification-counter").click(function () {
    var a = jQuery(this);
    if (!a.hasClass("notification-active")) {
        a.addClass("notification-active");
        jQuery(".notification-box").slideDown("fast")
    } else {
        a.removeClass("notification-active");
        jQuery(".notification-box").hide()
    }
    jQuery(".user-info").removeClass("user-active");
    jQuery(".user-dropbox").hide();
    return false
});
$(document).mouseup(function (a) {
    if (jQuery(a.target).parents().index() < 4 || jQuery(a.target).parents().index() > 7) {
        jQuery(".notification-counter").removeClass("notification-active");
        jQuery(".notification-box").hide();
        jQuery(".user-info").removeClass("user-active");
        jQuery(".user-dropbox").hide()
    }
});
jQuery(".utopia-widget-title").hover(function () {
    /*jQuery(this).after().append('<span class="collapse-widget">&nbsp;&nbsp;</span>')*/
}, function () {
    jQuery(this).children(".collapse-widget").remove()
});
/*
jQuery(".utopia-widget-title").click(function () {
    if (jQuery(this).next().is(":visible")) {
        jQuery(this).next().slideUp("fast");
        jQuery(this).css("border-bottom", "none");
        jQuery(this).addClass("utopia-widget-title-toggle")
    } else {
        jQuery(this).next().slideDown("fast");
        jQuery(this).removeClass("utopia-widget-title-toggle");
        jQuery(this).css("border-bottom", "1px solid #eee")
    }
});*/
jQuery(".search-panel").hover(function () {
    jQuery(".search-box img").hide();
    jQuery(".search-box form").show()
}, function () {
    jQuery(".search-box form").hide();
    jQuery(".search-box img").show()
});