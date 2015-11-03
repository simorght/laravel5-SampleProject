function batchDelete(url,crf_token,succ)
{
			var dataToSend = { 
    			pst_ids: []
			};
			$("#modal_OnlyText").dialog( "close" );
			startLoadingOverlay("loading_overlay");	
			$("#ajaxlist input:checkbox:checked").map(function(){
			dataToSend.pst_ids.push($(this).val());
			});
			
           $.ajax({
                url: url,
                type: 'DELETE',
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
function Delete(url,pst_id,crf_token,succ)
{
	$("#modal_OnlyText").dialog( "close" );
	startLoadingOverlay("loading_overlay");
	
	var dataToSend = { 
		pst_ids: pst_id
	};
			
	$.ajax({
		type: "DELETE",   
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
			 popupshow(xhr.responseText,'error');
			 popupshow($.parseJSON(xhr.responseText),'error');
		  }				  
     });
}