{!! HTML::style('css/arrow/arrow.css') !!}
<div id="content">
	<div id="rightbarleft">@include('admin.rightbar' , [ 'nbrPosts' => $nbrPosts , 'nbrComments' => $nbrComments])</div>
    <div id="articlebarright">
		<div class="Blkarticle">
        <form method="post">
            <input type="hidden" name="_method" value="PUT" id="_method" />        
        <div style="padding-bottom:20px">
        {{trans('layout/template.catagory')}}: 
        	<select id="tag" name="tag">
        	 <option value="" >{{trans('layout/template.All')}}</option> 
@foreach ($nbrTags as $key => $value) 
        	 <option value="{{ $key }}">{{ $value }}</option> 
@endforeach 
			</select>
            {{trans('admin/info.recstate')}}: 
        	<select id="approved" name="approved">
        	 <option value="1">{{trans('admin/info.cnfstate1')}}</option> 
        	 <option value="0">{{trans('admin/info.cnfstate0')}}</option> 
        	 <option value="2">{{trans('admin/info.cnfstate2')}}</option> 
			</select> 
            </div>           
    		<ul class="listposts"> 
            	<li class="chk" >
                    <input tabindex="1" type="checkbox" name="chkall" id="chkall" />                
                </li>
            	<li class='title'><a href="#" class="order" name='title'>{{trans('layout/template.titlepost')}}<span class="aucun"></span></a></li>
                <li class="email"><a href="#" class="order" name='email'>{{trans('layout/template.commenteremail')}}<span class="aucun"></span></a></li>
                <li class="update_at" ><a href="#" class="order green upArrow" name='created_at'>{{trans('layout/template.update_at')}}<span class="asc"></span></a></li>
                <li class="btn0" id="headdelbtn">
<?php 
					$Msg=trans('admin/template.noneaccpet');
					$Conent=trans('admin/template.noacccmtconfirm');						
					$actlnk=htmlspecialchars_decode("open_modal('batchUpdateApproved( \'".url('admin/updatespprove/0')."\' ,\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'0\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
					echo '<a href="#" class="deletebtn prevent" onclick="';
					echo $actlnk;
					echo '">'.trans('admin/template.noneaccpet').'</a>';
?>
                </li>
	            <li class="btn0" id="headrecbtn" style="display:none">
<?php 
					$Msg=trans('admin/template.accpet');
					$Conent=trans('admin/template.acccmtconfirm');						
					$actlnk=htmlspecialchars_decode("open_modal('batchUpdateApproved( \'".url('admin/updatespprove/0')."\' ,\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'1\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
					echo '<a href="#" class="editbtn prevent" onclick="';
					echo $actlnk;
					echo '">'.trans('admin/template.accpet').'</a>';
?>              
                </li>
			</ul>         
			<div id="ajaxlist" name="ajaxlist">
            @include('admin/Comment/AjaxCommentsList') 
            </div>
             <div class="clear"></div>
             <div class="link">{!! $links !!}</div>
             <div class="clear"></div>
             <input type="hidden" value="{{ $page }}" id="pagenumber" />            
        </form>
        </div>
                               
   </div>   
 <div class="clear"></div>  
</div>
<script type="text/javascript">
function setPaginate(){
$('.link' ).find( "a" ).click(
	function(e)
	{
		e.preventDefault();
		startLoadingOverlay("loading_overlay");
		url = $(this).attr('href');
		pieces = url.split("?");
		dataurl = pieces[1];
		
		$.ajax({
		  url: '{{ url('admin/comments/order') }}',
		  type: 'GET',
		  dataType: 'json',
		  data: dataurl,
		  success: function(data)
		  {
			  $('#ajaxlist').html(data.view);
			  $('.link').html(data.links);
			  stopLoadingOverlay("loading_overlay");
			  $("#pagenumber").val(dataurl.split('page=')[1]);
			  setPaginate();			  
		 },
		 error: function(xhr, textStatus, error)
		 {
			  stopLoadingOverlay("loading_overlay");  
			  popupshow($.parseJSON(xhr.responseText),'error');				  
		 }		  
		});	
});
  $('a.viewbtn').click(
		function(e)
		{
			e.preventDefault();
			startLoadingOverlay("loading_overlay");
			cmt_id = $(this).attr('cmt_id');
			// Send ajax
			$.ajax({
			  url: "{{ url('admin/comments/read') }}",
			  type: 'GET',
			  dataType: 'json',
			  data: {cmt_id:cmt_id , _token:'{{ csrf_token()}}' },
			  success: function(data)
			  {
				  html = "{{ trans('admin/template.commenteremail') }}: " + data.email+"<div class='i-divider_modal'></div>" +
				  "{{ trans('admin/template.commentername') }}: " + data.commenter+"<div class='i-divider_modal'></div>"  +
				  "{{ trans('layout/template.create_at') }}: " + data.created_at+"<div class='i-divider_modal'></div>"  +	
				  "{{ trans('admin/template.comment') }}: <br/>" + data.comment;  			  
				  stopLoadingOverlay("loading_overlay");
				  open_modal_WF("{{ trans('admin/template.comment') }}",html);				  
			  },
			  error: function(xhr, textStatus, error)
			  {
				  stopLoadingOverlay("loading_overlay"); 
			 	  popupshow(xhr.responseText,'error');				  				  
				  popupshow($.parseJSON(xhr.responseText),'error');				  
			  }
			});			
		}
	);
}
  $('#chkall').change(
		function()
		{
		$('.chkbox').prop('checked',$('#chkall').prop('checked'));			
		});
  $('.chkbox').change(
		function()
		{
			if ($('.chkbox').prop('checked')==false)
			{
				$('#chkall').prop('checked',false);
			}
		});
  $('select').change( 
		function()
		{
			startLoadingOverlay("loading_overlay");
			Sortf = $('a.green');
			sorted = Sortf.attr('name');
			page= $("#pagenumber").val();
			tag = $( "#tag option:selected" ).val();
			approved = $( "#approved option:selected" ).val();		
			// Sorting direction
			var sens;
			if($('span',Sortf).hasClass('aucun')) sens='aucun';
			else if ($('span',Sortf).hasClass('desc')) sens='desc';
			else if ($('span',Sortf).hasClass('asc')) sens='asc';

			var tri;
			if(sens == 'aucun' || sens == 'asc') {
			  tri = 'asc';
			} else if(sens == 'desc') {
			  tri = 'desc';
			}			
			// Send ajax
			$.ajax({
			  url: '{{ url('admin/comments/order') }}',
			  type: 'GET',
			  dataType: 'json',
			  data: "name=" + sorted + "&sens=" + tri+ "&tag=" + tag+ "&approved=" + approved,
			  success: function(data)
			  {
					$('#ajaxlist').html(data.view);
					$('.link').html(data.links);
					if (approved=="1")
					{
						$('#headrecbtn').hide();
						$('#headdelbtn').show();
					}
					else
					{
						$('#headrecbtn').show();
						$('#headdelbtn').hide();					
					}
						
					stopLoadingOverlay("loading_overlay");
					setPaginate();				  
			  },
			  error: function(xhr, textStatus, error)
			  {
					stopLoadingOverlay("loading_overlay");  
					popupshow(xhr.responseText,'error');
					popupshow($.parseJSON(xhr.responseText),'error');
			  }
			});			
		}
   );	
  // Sorting gestion
  $('a.order').click(
		function(e)
		{
			e.preventDefault();
			startLoadingOverlay("loading_overlay");
			sorted = $(this).attr('name');
			$('a.order').removeClass('green');
			$(this).addClass('green');
			
			// Sorting direction
			var sens;
			if($('span', this).hasClass('aucun')) sens='aucun';
			else if ($('span',this).hasClass('desc')) sens='desc';
			else if ($('span',this).hasClass('asc')) sens='asc';
			// Set to zero
			$('a.order span').removeClass().addClass('aucun');
			$('a.order').removeClass("upArrow");
			$('a.order').removeClass("downArrow");
			// Adjust selected
			$('span', this).removeClass();
			var tri;
			if(sens == 'aucun' || sens == 'asc') {
			  $('span', this).addClass('desc');
			  $(this).addClass("downArrow");
			  tri = 'desc';
			} else if(sens == 'desc') {
			  $('span', this).addClass('asc');
			  $(this).addClass("upArrow");
			  tri = 'asc';
			}
			tag = $( "#tag option:selected" ).val();
			approved = $( "#approved option:selected" ).val();
			page= $("#pagenumber").val();			
			// Send ajax
			$.ajax({
			  url: '{{ url('admin/comments/order') }}',
			  type: 'GET',
			  dataType: 'json',
			  data: "name=" + sorted + "&sens=" + tri+ "&tag=" + tag+ "&approved=" + approved + "&page=" + page,
			  success: function(data)
			  {
				  $('#ajaxlist').html(data.view);
				  $('.link').html(data.links);
				  stopLoadingOverlay("loading_overlay");
				  setPaginate();			  
			  },
			  error: function(xhr, textStatus, error)
			  {
					stopLoadingOverlay("loading_overlay");  
					popupshow($.parseJSON(xhr.responseText),'error');				  
			  }
			});			
		}
	);
$('a.prevent').click(function(e){e.preventDefault();});  
setPaginate();
</script>