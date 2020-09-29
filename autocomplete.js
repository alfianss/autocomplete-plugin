jQuery(document).ready(function($) {
	
	// AJAX url
	var ajax_url = autocomplete_ajax.ajax_url;	
	var data = {
	  'action': 'autocomplete_post'
	};
  
	$( "#search" ).keyup(function(){
		$.ajax({
			url: ajax_url,
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(response){
				console.log(response);		
			}
		});
	});


});