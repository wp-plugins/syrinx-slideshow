(function ($) {
    var $info = $(".syx-new-slide-dialog");
    $info.dialog({
        'dialogClass': 'wp-dialog',
        'title': 'Create New Slideshow',
        'modal': true,
        'width': 400,
        'height': 250,
        'autoOpen': false,
        'closeOnEscape': true,
        'buttons': {
            "Close": function () {
                $(this).dialog('close');
                var val = $info.find("#syx_new_ssId").val();
                $.ajax("/wp-admin/admin-ajax.php", {
                    data: {
                        action: "syx_createNew_slideshow",
                        ssId: val
                    },
                    type: "POST"
                }).done(function () {
                    window.location.reload();
                });
            }
        }});

    var $currentSlideshow = null;
    function showSlideshow(id) {
        $(".syx-slideplayer").html("<div class='syx-slideshow-core'></div>").find(".syx-slideshow-core").load("/wp-admin/admin-ajax.php?action=syx_get_slideshow", {
            id: id
        }, function () {
            $currentSlideshow = $("#" + id).syrinxSlider({ "saveUrl": "/wp-admin/admin-ajax.php", "saveUrlData": { "action": "syx_save_slideshow"} }).syrinxSlideShowEditor();
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
    }).on("click", ".syx-slideshow-editor a.syx-new-slide", function (event) {
        event.preventDefault();
        $info.dialog('open');
    }).on("click", ".syx-slideshow-editor .submitdelete", function (event) {
        event.preventDefault();
        $.ajax("/wp-admin/admin-ajax.php", {
            data: {
                action: "syx_delete_slideshow",
                ssId: $(this).parentsUntil("tbody").last().data("slideshowId")
            },
            type: "POST"
        }).done(function () {
            window.location.reload();
        });
    }).on("sshowedit.uploadImg", function (event) {
        formfield = "uploadField";// $('#top_bg_img').attr('id');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    });

    window.send_to_editor = function (html) {
        imgurl = $('img', html).attr('src');
        tb_remove();
        //alert(imgurl);
        if ($currentSlideshow)
            $currentSlideshow.syrinxSlideShowEditor("setCurrentSlideImage", imgurl);
    }

})(jQuery);