 $(document).ready(function() {
        var editor = $('.bbcode-editor');

        editor.sceditor({
            plugins: "bbcode",
            style: "/media/com_forums/css/jquery.sceditor.default.min.css",
            toolbarExclude: "emoticon,print,rtl,ltr,youtube,date,time,cut,copy,paste,pastetext,email",
            emoticonsEnabled: false,
            autoExpand: true,
            autoUpdate: true,
            resizeWidth: false,
            width: "100%"
        });

        var instance = editor.sceditor('instance');
        var reg = /\S/;

        instance.focus(function(e) {
            var val = editor.sceditor('instance').val()
            var el = $(this);

            if(reg.test(val)) {
                el.addClass('focus');
            } else {
                el.addClass('error');
            }
        });

        instance.keyUp(function(e) {
            var val = editor.sceditor('instance').val()
            var el = $(this);

            if(reg.test(val)) {

                if(el.hasClass('error')) {
                    el.removeClass('error');
                }

                if(!el.hasClass('focus')) {
                    el.addClass('focus');
                }

            } else {

                if(el.hasClass('focus')) {
                    el.removeClass('focus');
                }

                if(!el.hasClass('err')) {
                    el.addClass('error');
                }
            }
        });

        instance.blur(function(e) {
            $(this).removeClass('focus error');
        });

        $('body').on('click', '#entity-form button[type="submit"]', function(evt) {
            evt.preventDefault();

            var val = $('.bbcode-editor').sceditor('instance').val();

            if(reg.test(val)) {
                $('#entity-form').submit();
            } else {
                $('.bbcode-editor').sceditor('instance').focus();
            }
        });
    });