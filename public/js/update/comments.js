function batchUpdateApproved(url,crf_token,succ,approved)
{
			var dataToSend = { 
    			approved: approved, 
    			cmt_ids: []
			};
			$("#modal_OnlyText").dialog( "close" );
			startLoadingOverlay("loading_overlay");	
			$("#ajaxlist input:checkbox:checked").map(function(){
			dataToSend.cmt_ids.push($(this).val());
			});
			_method = $("#_method").val();			
           $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: {"SendParam":JSON.stringify(dataToSend) , _token:crf_token , _method:_method},
				success: function(data)
				  {
					$( dataToSend.cmt_ids ).each(function()
						{
							$("#dv"+this).fadeOut(1000);
						});
					stopLoadingOverlay("loading_overlay");
					popupshow(succ,'succ');
				  },
				 error: function(xhr, textStatus, error)
				  {
					stopLoadingOverlay("loading_overlay");
					popupshow($.parseJSON(xhr.responseText),'error');
  				  }				  
            });
}
function UpdateApproved(url,cmt_id,crf_token,succ,approved)
{
	$("#modal_OnlyText").dialog( "close" );
	startLoadingOverlay("loading_overlay");
	
	var dataToSend = { 
		approved: approved, 
		cmt_ids: cmt_id
	};
	_method = $("#_method").val();
	$.ajax({
		type: "POST",   
		url: url,
		dataType: 'json',
		data: {"SendParam":JSON.stringify(dataToSend) , _token:crf_token , _method:_method},
		success: function(data)
		  {
			$("#dv"+cmt_id).fadeOut(1000); 
			popupshow(succ,'succ');
			stopLoadingOverlay("loading_overlay");
		  },
		 error: function(xhr, textStatus, error)
		  {
			 stopLoadingOverlay("loading_overlay");
			 popupshow(xhr.responseText,'error');
			 popupshow($.parseJSON(xhr.responseText),'error');
		  }				  
     });
}