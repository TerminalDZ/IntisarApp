if(localStorage.getItem("color"))
    $("#color" ).attr("href", "../assets/css/"+localStorage.getItem("color")+".css" );
if(localStorage.getItem("dark"))
    $("body").attr("class", "dark-only");
$('<div class=customizer-links><div class="flex-column nac-pills nav"id=c-pills-tab role=tablist aria-orientation=vertical><a aria-controls=c-pills-profile aria-selected=false class=nav-link data-toggle=pill href=#c-pills-profile id=c-pills-profile-tab role=tab><div class="color-settings settings"><img alt=""src=../assets/images/color-picker.png></div></a></div></div><div class=customizer-contain><div class=tab-content id=c-pills-tabContent><div class="custom-scrollbar customizer-body"><i class="icofont-close icon-close"></i><div class="fade tab-pane"id=c-pills-profile role=tabpanel aria-labelledby=c-pills-profile-tab><h6>وضع المضيء</h6><ul class="layout-grid customizer-color"><li class=color-layout data-attr=color-1 data-primary=#7e37d8 data-secondary=#fe80b2><div></div><li class=color-layout data-attr=color-2 data-primary=#0288d1 data-secondary=#26c6da><div></div><li class=color-layout data-attr=color-3 data-primary=#8e24aa data-secondary=#ff6e40><div></div><li class=color-layout data-attr=color-4 data-primary=#4c2fbf data-secondary=#2e9de4><div></div><li class=color-layout data-attr=color-5 data-primary=#7c4dff data-secondary=#7b1fa2><div></div><li class=color-layout data-attr=color-6 data-primary=#3949ab data-secondary=#4fc3f7><div></div></ul><h6>وضع الظلام</h6><ul class="layout-grid customizer-color dark"><li class=color-layout data-attr=color-1 data-primary=#7e37d8 data-secondary=#fe80b2><div></div><li class=color-layout data-attr=color-2 data-primary=#0288d1 data-secondary=#26c6da><div></div><li class=color-layout data-attr=color-3 data-primary=#8e24aa data-secondary=#ff6e40><div></div><li class=color-layout data-attr=color-4 data-primary=#4c2fbf data-secondary=#2e9de4><div></div><li class=color-layout data-attr=color-5 data-primary=#7c4dff data-secondary=#7b1fa2><div></div><li class=color-layout data-attr=color-6 data-primary=#3949ab data-secondary=#4fc3f7><div></div></ul><h6>وضع المختلط</h6><ul class="layout-grid customizer-mix"><li class="color-layout active"data-attr=light-only><div class="bg-light header"><ul><li><li><li></ul></div><div class=body><ul><li class="bg-light sidebar"><li class="body bg-light"></ul></div><li class=color-layout data-attr=sidebar-dark><div class="bg-light header"><ul><li><li><li></ul></div><div class=body><ul><li class="bg-dark sidebar"><li class="body bg-light"></ul></div><li class=color-layout data-attr=dark-only><div class="bg-dark header"><ul><li><li><li></ul></div><div class=body><ul><li class="bg-dark sidebar"><li class="body bg-dark"></ul></div></ul></div></div></div></div>').appendTo($('body'));
(function() {
})();
//live customizer js
$(document).ready(function() {
    $(".customizer-links").click(function(){
        $(".customizer-contain").addClass("open");
        $(".customizer-links").addClass("open");
    });

    $(".close-customizer-btn").on('click', function() {
        $(".floated-customizer-panel").removeClass("active");
    });

    $(".customizer-contain .icon-close").on('click', function() {
        $(".customizer-contain").removeClass("open");
        $(".customizer-links").removeClass("open");
    });

    $(".customizer-color li").on('click', function() {
        $(".customizer-color li").removeClass('active');
        $(this).addClass("active");
        var color = $(this).attr("data-attr");
        var primary = $(this).attr("data-primary");
        var secondary = $(this).attr("data-secondary");
        localStorage.setItem("color", color);
        localStorage.setItem("primary", primary);
        localStorage.setItem("secondary", secondary);
        localStorage.removeItem("dark");
        $("#color" ).attr("href", "../assets/css/"+color+".css" );
        $(".dark-only").removeClass('dark-only');
        location.reload(true);
    });

    $(".customizer-color.dark li").on('click', function() {
        $(".customizer-color.dark li").removeClass('active');
        $(this).addClass("active");
        $("body").attr("class", "dark-only");
        localStorage.setItem("dark", "dark-only");
    });


    $(".customizer-mix li").on('click', function() {
        $(".customizer-mix li").removeClass('active');
        $(this).addClass("active");
        var mixLayout = $(this).attr("data-attr");
        $("body").attr("class", mixLayout);
    });


    $('.sidebar-setting li').on('click', function() {
        $(".sidebar-setting li").removeClass('active');
        $(this).addClass("active");
        var sidebar = $(this).attr("data-attr");
        $(".page-sidebar").attr("sidebar-layout",sidebar);
    });

    $('.sidebar-main-bg-setting li').on('click', function() {
        $(".sidebar-main-bg-setting li").removeClass('active')
        $(this).addClass("active")
        var bg = $(this).attr("data-attr");
        $(".page-sidebar").attr("class", "page-sidebar "+bg);
    });

    $('.sidebar-type li').on('click', function () {
        $(".sidebar-type li").removeClass('active');
        var type = $(this).attr("data-attr");

        var boxed = "";
        if($(".page-wrapper").hasClass("box-layout")){
            boxed = "box-layout";
        }
        $(this).addClass("active");
    });

    $('.main-layout li').on('click', function() {
        $(".main-layout li").removeClass('active');
        $(this).addClass("active");
        var layout = $(this).attr("data-attr");
        $("body").attr("main-theme-layout", layout);

        $("html").attr("dir", layout);
    });

    $('.main-layout .box-layout').on('click', function() {
        $(".main-layout .box-layout").removeClass('active');
        $(this).addClass("active");
        var layout = $(this).attr("data-attr");
        $("body").attr("main-theme-layout", "box-layout");
        $("html").attr("dir", layout);
    });

});

