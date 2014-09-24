define(['jquery', 'basepath'], function ($, basepath) {	
	setInterval(function(){
		$('#egood_download_count').load($('#egood_download_count').data('url'));
	}, 10000);
	$(document).ready(function() {
		jQuery('#EGoodAddEditForm').validate({
			errorClass: "error",
			rules:{
					"data[Egood][title]":{
							required: true
					},
					"data[Egood][description]":{
							required: true
					}
			},
			messages:{
					"data[Egood][title]":{
							required: "Please enter Title"
					},
					"data[Egood][description]":{
							required: "Please enter description"
					}
			}
		});
	});
});
