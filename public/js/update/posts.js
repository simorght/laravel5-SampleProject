function batchUpdateActive(url,crf_token,succ,active)
{
			var dataToSend = { 
    			active: active, 
    			pst_ids: []
			};
			$("#modal_OnlyText").dialog( "close" );
			startLoadingOverlay("loading_overlay");	
			$("#ajaxlist input:checkbox:checked").map(function(){
			dataToSend.pst_ids.push($(this).val());
			});
			
           $.ajax({
                url: url,
                type: 'PUT',
                dataType: 'JSON',
                data: {"SendParam":JSON.stringify(dataToSend) , _token:crf_token},
				success: function(data)
				  {
					$( dataToSend.pst_ids ).each(function()
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
function updateActive(url,pst_id,crf_token,succ,active)
{
	$("#modal_OnlyText").dialog( "close" );
	startLoadingOverlay("loading_overlay");
	
	var dataToSend = { 
		active: active, 
		pst_ids: pst_id
	};
			
	$.ajax({
		type: "PUT",   
		url: url,
		dataType: 'json',
		data: {"SendParam":JSON.stringify(dataToSend) , _token:crf_token},
		success: function(data)
		  {
			$("#dv"+pst_id).fadeOut(1000); 
			popupshow(succ,'succ');
			stopLoadingOverlay("loading_overlay");
		  },
		 error: function(xhr, textStatus, error)
		  {
			 stopLoadingOverlay("loading_overlay"); 
			 popupshow($.parseJSON(xhr.responseText),'error');
		  }				  
     });
}