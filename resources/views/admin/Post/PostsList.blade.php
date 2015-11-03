{!! HTML::style('css/arrow/arrow.css') !!}
<div id="content">
	<div id="rightbarleft">@include('admin.rightbar' , [ 'nbrPosts' => $nbrPosts , 'nbrComments' => $nbrComments])</div>
    <div id="articlebarright">
		<div class="Blkarticle">
        <form action="" method="post">
        <div style="padding-bottom:20px">
        {{trans('layout/template.catagory')}}: 
        	<select id="tag" name="tag">
        	 <option value="" >{{trans('layout/template.All')}}</option> 
@foreach ($nbrTags as $key => $value) 
        	 <option value="{{ $key }}">{{ $value }}</option> 
@endforeach 
			</select>
            {{trans('admin/info.recstate')}}: 
        	<select id="active" name="active">
        	 <option value="true">{{trans('admin/info.recstate1')}}</option> 
        	 <option value="false">{{trans('admin/info.recstate0')}}</option> 
			</select>
            <div style="float:left">
            	<a href="{!! Route('addPostForm') !!}" class="editbtn">{{trans('admin/template.insert')}}</a>
            </div> 
            </div>           
    		<ul class="listposts"> 
            	<li class="chk" >
                    <input tabindex="1" type="checkbox" name="chkall" id="chkall" />                
                </li>
            	<li class='title'><a href="#" class="order" name='title'>{{trans('layout/template.titlepost')}}<span class="aucun"></span></a></li>
                <li class="tag"><a href="#" class="order" name='tag'>{{trans('layout/template.tag')}}<span class="aucun"></span></a></li>
                <li class="update_at" ><a href="#" class="order green upArrow" name='updated_at'>{{trans('layout/template.update_at')}}<span class="asc"></span></a></li>
                <li class="btn0" id="headactbtn">
					<?php 
						$Msg=trans('admin/template.notactive');
						$Conent=trans('admin/template.notactiveconfirm');						
						 $dellnk=htmlspecialchars_decode("open_modal('batchUpdateActive( \'".route('updateActive')."\' ,\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'false\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
						 echo '<a href="#" class="editbtn prevent" onclick="';
						 echo $dellnk;
						 echo '">'.trans('admin/template.notactive').'</a>';
					?>
                </li>                
	            <li class="btn0" id="headrecbtn" style="display:none">
					<?php 
						$Msg=trans('admin/template.active');
						$Conent=trans('admin/template.activeconfirm');						
						 $dellnk=htmlspecialchars_decode("open_modal('batchUpdateActive( \'".route('updateActive')."\' ,\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'true\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
						 echo '<a href="#" class="editbtn prevent" onclick="';
						 echo $dellnk;
						 echo '">'.trans('admin/template.active').'</a>';						
					 ?>                
                </li>
                <li class="btn0" id="headdelbtn">
                    <?php
						$Msg=trans('admin/template.delete');
						$Conent=trans('admin/template.delconfirm');						
						 $dellnk=htmlspecialchars_decode("open_modal('batchDelete( \'".route('deletePost')."\' ,\'".csrf_token()."\',\'".trans('layout/template.succ')."\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
						 echo '<a href="#" class="deletebtn prevent" onclick="';
						 echo $dellnk;
						 echo '">'.trans('admin/template.delete').'</a>';					
					?>
                </li>                
			</ul>         
			<div id="ajaxlist" name="ajaxlist">
            @include('admin/Post/AjaxPostsList') 
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
		  url: '{{ url('admin/posts/order') }}',
		  type: 'GET',
		  dataType: 'json',
		  data: dataurl
		})
		.done(function(data) {
		  $('#ajaxlist').html(data.view);
		  $('.link').html(data.links);
		  stopLoadingOverlay("loading_overlay");
		  $("#pagenumber").val(dataurl.split('page=')[1]);
		  setPaginate();
		  
		})
		.fail(function(xhr, textStatus, error) {
		  popupshow(error,'error');
		  stopLoadingOverlay("loading_overlay");
		});	
});
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
			active = $( "#active option:selected" ).val();		
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
			  url: '{{ url('admin/posts/order') }}',
			  type: 'GET',
			  dataType: 'json',
			  data: "name=" + sorted + "&sens=" + tri+ "&tag=" + tag+ "&active=" + active
			})
			.done(function(data) {
				$('#ajaxlist').html(data.view);
				$('.link').html(data.links);
				if (active=="false")
				{
					$('#headrecbtn').show();
					$('#headactbtn').hide();
				}
				else
				{
					$('#headrecbtn').hide();
					$('#headactbtn').show();
				}
					
				stopLoadingOverlay("loading_overlay");
				setPaginate();
			  
			})
			.fail(function() {
				stopLoadingOverlay("loading_overlay");
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
			// Send ajax
			
			tag = $( "#tag option:selected" ).val();
			active = $( "#active option:selected" ).val();
			page= $("#pagenumber").val();
			$.ajax({
			  url: '{{ url('admin/posts/order') }}',
			  type: 'GET',
			  dataType: 'json',
			  data: "name=" + sorted + "&sens=" + tri+ "&tag=" + tag+ "&active=" + active + "&page=" + page
			})
			.done(function(data) {
			  $('#ajaxlist').html(data.view);
			  $('.link').html(data.links);
			  stopLoadingOverlay("loading_overlay");
			  setPaginate();
			  
			})
			.fail(function(xhr, textStatus, error) {
			  popupshow(error,'error');
			  stopLoadingOverlay("loading_overlay");
			});			
		}
	);
$('a.prevent').click(function(e){e.preventDefault();});  
setPaginate();
</script>