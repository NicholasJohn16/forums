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

		$('a[data-action="promote"]').on('click', function(evt) {
			evt.preventDefault();
			var btn = $(this);

			$.ajax({
				method: 'post',
				url: 'index.php?option=com_forums',
				data: {
					action: 'promote'
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
			var quickreply = $('.'+btn.data('target'));

			if(quickreply.is(':visible')) {
				console.log('visible');
			} else {
				console.log('invisible');
			}
			// quickreply.removeClass('hidden');
			quickreply.slideDown('slow', function() {
				quickreply.find('textarea').focus();
			});

			if(btn.data('quote')) {
				quickreply.find('textarea').val(btn.data('quote'));
			}


			cancelQuickreply = function(evt) {
				evt.preventDefault();
				// quickreply.addClass('hidden').removeClass('in');
				quickreply.slideUp('slow');
				quickreply.find('textarea').val('');
				console.log(this);
				$(this).off('click', cancelQuickreply);
			}

			postReply = function(evt) {
				evt.preventDefault();
				$(this).prop('disabled', true);
				var form = quickreply.find('form');

				$.ajax({
					method: 'post',
					url: form.attr('action'),
					data: {
						title: form.find('input[name="title"]').val(),
						body: form.find('textarea[name="body"]').val()
					},
					beforeSend: function() {
						quickreply.fadeTo('fast', 0.3).addClass('uiActivityIndicator');
					},
					success: function(response, status, xhr) {
						quickreply.fadeTo('fast', 1).removeClass('uiActivityIndicator').addClass('hidden');
						window.location = xhr.getResponseHeader('location');
					}
				})

			}

			quickreply.find('button[data-action="cancel"]').on('click', cancelQuickreply);
			quickreply.find('button[type="submit"]').on('click', postReply);

		});	

	});
}(jQuery, document, window));