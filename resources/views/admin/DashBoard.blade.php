@extends('admin.Template')  

@section('hstyle')
    {!! HTML::style('css/fallr/jquery-fallr-1.3.css') !!}
    {!! HTML::style('css/validators/validationEngine.jquery.css') !!}
    {!! HTML::style('css/jquery-ui-1.8.16.custom.css') !!}
    {!! HTML::style('css/element/jqueryui_button/jquery.ui.button.min.css') !!}
    {!! HTML::style('css/element/jqueryui_dialog/jquery.ui.dialog.min.css') !!}    
@stop
@section('hscript')
    <script type="text/javascript">
    $('#modal_OnlyText').dialog({autoOpen: false,modal: true,draggable: true,});
    </script>
@stop 
@section('bscript')
    {!! HTML::script('js/fallr/fallr1.3.js') !!}
    {!! HTML::script('js/utility/popup.js') !!}
    {!! HTML::script('js/validators/jquery.validationEngine.js') !!}
    {!! HTML::script('js/validators/languages/jquery.validationEngine-fa_3.js') !!}
    {!! HTML::script('js/validators/customValidators_3.js') !!}
    {!! HTML::script('js/jquery-ui-1.9.0.custom.min.js')!!}
    {!! HTML::script('js/update/posts.js')!!}
    @include('admin.Modal', array('Msg'=>trans('admin/template.delete') , 'Fn' => '' , 'Conent' => trans('admin/template.delconfirm' )))    
@stop

@section('content')                 
<div id="content">
	<div id="rightbarleft">@include('admin.rightbar' , [ 'nbrPosts' => $nbrPosts , 'nbrComments' => $nbrComments])</div>
    <div id="articlebarright">
    	@foreach($posts as $post)
        	<div class="Blkarticle" id="dv{{ $post->pst_id }}">
            {!! link_to('post/'.$post->pst_id,$post->title,['class' => 'title' ]) !!}
            
                <ul class="postcategories">
                	<li>
                    	{{ $post->JalaliUpdated_at." - ".$post->JalaliUpdatedTime }}
                    </li>
                </ul>
                <div class="Blkarticlecontent">
                   <p>{!! $post->read_more !!}</p>
                </div>
                <div class="clear"></div>
                <div class="catagorytag">
                  <ul>
                      <li>
                      {!! link_to(route('editPostForm',"$post->pst_id"),trans('admin/template.edit'),['class' => 'viewbtn']) !!}
                      </li>
                      <li>
                      <?php
						 $Msg=trans('admin/template.notactive');
						 $Conent=trans('admin/template.notactiveconfirm');						
						 $dellnk=htmlspecialchars_decode("open_modal('updateActive( \'".route('updateActive')."\' ,".$post->pst_id.",\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'false\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
						 echo '<a href="#" class="editbtn prevent" onclick="';
						 echo $dellnk;
						 echo '">'.trans('admin/template.notactive').'</a>';
					   ?>
                      </li>  
                      <li>
                      <?php
						$Msg=trans('admin/template.delete');
						$Conent=trans('admin/template.delconfirm');						
						$dellnk=htmlspecialchars_decode("open_modal('Delete( \'".route('deletePost')."\' ,".$post->pst_id.",\'".csrf_token()."\',\'".trans('layout/template.succ')."\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
						echo '<a href="#" class="deletebtn prevent" onclick="';
						echo $dellnk;
						echo '">'.trans('admin/template.delete').'</a>';
					   ?>
                      </li>                                                          
                  </ul>
                  <div class="clear"></div>
                </div>
                <br />                
            </div>               
        @endforeach 
    	{!! $links !!}     
    </div>
</div>
<div class="clear"></div>      

@stop