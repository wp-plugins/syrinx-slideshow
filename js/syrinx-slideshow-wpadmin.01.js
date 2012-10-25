(function ($) {
    function showSlideshow(id) {
        $(".syx-slideplayer").html("<div class='syx-slideshow-core'></div>").find(".syx-slideshow-core").load("/wp-admin/admin-ajax.php?action=syx_get_slideshow", {
            id: id
        }, function () {
            $("#" + id).syrinxSlider({ "saveUrl": "/wp-admin/admin-ajax.php", "saveUrlData": { "action": "syx_save_slideshow"} }).syrinxSlideShowEditor();
        });
    }
    $("body").on("change", ".syx-slide-id", function (event) {
        var $nsDiv = $(this).parent().parent().find(".syx-new-slide-id");
        if ($(this).val() == "_CreateNew_")
            $nsDiv.show();
        else
            $nsDiv.hide();
    }).on("click", ".syx-slideshows-ids li", function (event) {
        //alert($(this).text());
        $(".syx-slideshows-ids li").removeClass("selected");
        $(this).addClass("selected");
        var id = $(this).text();
    }).on("click", "a.syx-view", function (event) {
        event.preventDefault();
        showSlideshow($(this).parentsUntil("tbody").last().data("slideshowId"));
    }).on("click", ".syx-slideshow-editor a.add-new-h2", function (event) {
        event.preventDefault();
        
    });
})(jQuery);