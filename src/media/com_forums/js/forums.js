(function($, document, window) {

	$(document).ready(function() {

		$('a[data-action="recount"]').on('click', function(evt) {
			evt.preventDefault();
			var btn = $(this);

			$.ajax({
				method: 'post',
				url: 'index.php?option=com_forums',
				data: {
					action: 'recount'
				},
				beforeSend: function() {
					btn.fadeTo('fast', 0.3).addClass('uiActivityIndicator');
				},
				success: function() {
					btn.fadeTo('fast', 1).removeClass('uiActivityIndicator');
				}
			});

		});

		$('body').on('click', 'a[data-action="lock"], a[data-action="unlock"]', function(evt) {
			evt.preventDefault();
			var btn = $(this);

			$.ajax({
				method: 'post',
				url: btn.attr('href'),
				data: {
					action: btn.data('action')
				},
				beforeSend: function() {
					btn.fadeTo('fast', 0.3).addClass('uiActivityIndicator');
				},
				success: function() {
					btn.fadeTo('fast', 1).removeClass('uiActivityIndicator');
				}
			});

		});

		$('body').on('click', 'a[data-action="quickreply"], a[data-action="quickquote"]', function(evt) {
			evt.preventDefault();

			var btn = $(this);
			var form = $('#entity-form');
			var editor = $('.bbcode-editor').sceditor('instance');

			editor.val('');

			if(btn.data('quote')) {
				editor.insert(btn.data('quote'));
			}

			$('body').animate({
				scrollTop: form.offset().top
			}, 1000);

			editor.focus();
		});	

	});
}(jQuery, document, window));