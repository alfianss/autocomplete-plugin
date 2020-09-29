jQuery(document).ready(function($) {
	
	// AJAX url
	var ajax_url = autocomplete_ajax.ajax_url;	

	$( "#search" ).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: ajax_url,
				type: 'post',
				data: {
					'action': 'autocomplete_post',
					'search': $('#search').val(),
				},
				dataType: 'json',
				success: function(data){										
					response( data );
				}
			});
		},
	});

	$( "#submit" ).click(function(){		
		$.ajax({
			url: ajax_url,
			type: 'post',
			data: {
				'action': 'list_post',
				'submit': $('#search').val(),
			},
			dataType: 'json',
			success: function(data){	
				var html = '';
				$.each(data, function(index, item){
					html += '<div><h2>'+item+'</h2></div>';
				});				
				
				$('#result').html(html);
			}
		});
	});

});