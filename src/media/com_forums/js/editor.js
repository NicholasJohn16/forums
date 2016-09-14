 $(document).ready(function() {
        var textarea = $('.bbcode-editor');

        textarea.sceditor({
            plugins: "bbcode",
            style: "/media/com_forums/css/jquery.sceditor.default.min.css",
            toolbarExclude: "emoticon,print,rtl,ltr,youtube,date,time,cut,copy,paste,pastetext,email",
            emoticonsEnabled: false,
            autoExpand: true,
            autoUpdate: true,
            resizeWidth: false,
            width: "100%"
        });

        var editor = textarea.sceditor('instance');
        var reg = /\S/;

        // editor.focus(function(e) {
        //     var val = editor.val()
        //     var el = $(this);

        //     if(reg.test(val)) {
        //         el.addClass('focus').removeClass('error');
        //     } else {
        //         el.addClass('error').removeClass('focus');
        //     }
        // });

        // editor.keyUp(function(e) {
        //     var val = editor.val()
        //     var el = $(this);

        //     if(reg.test(val)) {

        //         // if(el.hasClass('error')) {
        //             el.removeClass('error').addClass('focus');
        //         // }

        //         // if(!el.hasClass('focus')) {
        //             // el.addClass('focus');
        //         // }

        //     } else {

        //         // if(el.hasClass('focus')) {
        //             el.removeClass('focus').addClass('error');
        //         // }

        //         // if(!el.hasClass('err')) {
        //             // el.addClass('error');
        //         // }
        //     }
        // });

        // editor.blur(function(e) {
        //     $(this).removeClass('focus error');
        // });

        $('body').on('click', '#entity-form button[type="submit"]', function(evt) {
            evt.preventDefault();

            var val = editor.val();

            if(reg.test(val)) {
                $('#entity-form').submit();
            } else {
                editor.focus();
            }
        });
    });