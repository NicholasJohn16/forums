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

        editor.sceditor('instance').focus(function(e) {
            var val = editor.sceditor('instance').val()
            
            if(/\S/.test(val)) {
                $(this).addClass('focus');
            } else {
                $(this).addClass('error');
            }
        });

        editor.sceditor('instance').keyUp(function(e) {
            var val = editor.sceditor('instance').val()
            
            if(/\S/.test(val)) {
                $(this).removeClass('error').addClass('focus');
            } else {
                $(this).removeClass('focus').addClass('error');
            }
        });

        editor.sceditor('instance').blur(function(e) {
            $(this).removeClass('focus error');
        });

        $('body').on('click', '#entity-form button[type="submit"]', function(evt) {
            evt.preventDefault();

            var val = $('.bbcode-editor').sceditor('instance').val();

            if(/\S/.test(val)) {
                $('#entity-form').submit();
            } else {
                $('.bbcode-editor').sceditor('instance').focus();
            }
        });
    });