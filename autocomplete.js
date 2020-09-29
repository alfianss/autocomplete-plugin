jQuery(document).ready(function($) {
	
	// AJAX url
	var ajax_url = autocomplete_ajax.ajax_url;	
  
	// $( "#search" ).keyup(function(){
	// 	$.ajax({
	// 		url: ajax_url,
	// 		type: 'post',
	// 		data: {
	// 			'action': 'autocomplete_post',
	// 			'search': $(this).val(),
	// 		},
	// 		dataType: 'json',
	// 		success: function(data){
				
	// 			console.log(data);
	// 		}
	// 	});
	// });

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

});