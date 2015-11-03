@extends('admin.Template')  

@section('hstyle')
    {!! HTML::style('css/fallr/jquery-fallr-1.3.css') !!}
    {!! HTML::style('css/validators/validationEngine.jquery.css') !!}
    {!! HTML::style('css/jquery-ui-1.8.16.custom.css') !!}
    {!! HTML::style('css/element/jqueryui_button/jquery.ui.button.min.css') !!}
    {!! HTML::style('css/element/jqueryui_dialog/jquery.ui.dialog.min.css') !!}    
@stop

@section('bscript')
    {!! HTML::script('js/fallr/fallr1.3.js') !!}
    {!! HTML::script('js/utility/popup.js') !!}
    {!! HTML::script('js/validators/jquery.validationEngine.js') !!}
    {!! HTML::script('js/validators/languages/jquery.validationEngine-fa_3.js') !!}
    {!! HTML::script('js/validators/customValidators_3.js') !!}
    {!! HTML::script('js/jquery-ui-1.9.0.custom.min.js')!!}
    {!! HTML::script('ckeditor/ckeditor.js') !!}    
	<script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("#PostContentForm").validationEngine();
            });
    </script>  
	<script>
	var config = {
		codeSnippet_theme: 'Monokai',
		language: '{{ config('app.locale') }}',
		height: 100,
		filebrowserBrowseUrl: '{!! url($url) !!}',
		toolbarGroups: [
			{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
			{ name: 'links' },
			{ name: 'insert' },
			{ name: 'forms' },
			{ name: 'tools' },
			{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
			{ name: 'others' },
			//'/',
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
			{ name: 'styles' },
			{ name: 'colors' }
		]
	};

	CKEDITOR.replace( 'read_more', config);

	config['height'] = 400;		

	CKEDITOR.replace( 'Pcontent', config);

	$("#title").keyup(function(){
			var str = sansAccent($(this).val());
			str = str.replace(/[^a-zA-Z0-9\s]/g,"");
			str = str.toLowerCase();
			str = str.replace(/\s/g,'-');
			$("#permalien").val(str);        
		});

  </script>       
@stop
@section('content')
<div id="content">
	<div id="rightbarleft">
    	@include('admin.rightbar' , [ 'nbrPosts' => $nbrPosts , 'nbrComments' => $nbrComments])
    </div>
{{-- -------------------------------------------- --}}
    <div id="articlebarright">
		<form action="{!! $FormUrl !!}" id="PostContentForm">
        <input type="hidden" name="_method" id="_method"  value="{{$FormMethod}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<div class="Blkarticle single">
			<label for="title">{{ trans('admin/template.posttitle') }}: </label>
            <input type="text" name="title" id="title" value="@if(isset($post)){{$post->title}}@endif" size="40" tabindex="2" aria-required='true' class="validate[required] i-text" />

			<label for="tag">{{ trans('admin/template.posttag') }}: </label>
			<select id="tag" name="tag">

                @foreach ($nbrTags as $key => $value) 
                             <option value="{{$key}}"   
                             @if (isset($post))
                                @if ($post->tag == $key)
                                    selected="selected"
                                @endif    
                             @endif
                             >{{$value}}</option> 
                @endforeach 
			</select>
            <input type="submit" value="@if(isset($post)){{trans('admin/template.edit') }}@else{{trans('admin/template.insert')}}@endif" class="editbtn noborderbtn"  />
			<div class="Blkarticlecontent">
            	<label for="read_more" ><small>{{ trans('admin/template.read_more') }}:</small> </label>
                <textarea id="read_more" class="validate[required] i-text" name="read_more" >@if(isset($post)){{$post->read_more}}@endif</textarea>
            </div>
            <div class="Blkarticlecontent">
            	<label for="Pcontent"><small>{{ trans('admin/template.Pcontent') }}:</small></label>
                <textarea id="Pcontent" class="validate[required] i-text" name="Pcontent" >@if(isset($post)){{$post->content}}@endif</textarea>
            </div>    
            <div class="clear"></div>
            <input type="hidden" name="pst_id" id="pst_id" value="@if(isset($post)){{$post->pst_id}}@endif" />
         </form>
	</div> 
{{-- -------------------------------------------- --}}
<script type="text/javascript">
$("#PostContentForm").submit(function (e){
										   
             // Stop form from submitting normally
		    e.preventDefault();
			if ($(this).validationEngine('validate'))
			{
				startLoadingOverlay("loading_overlay");
				var $this = $(this);
				var url = $(this).attr('action');
				var method = $("#_method").val();
				CKEDITOR.instances['Pcontent'].updateElement();
				CKEDITOR.instances['read_more'].updateElement();			
			   $.ajax({
					url: url,
					type: 'POST',
					dataType: 'JSON',
					data: $(this).serialize(),
					success: function(data)
					  {
						stopLoadingOverlay("loading_overlay");  
						popupshow("{{trans('layout/template.succ') }}",'succ');
						setTimeout(window.location.href = "{!! URL::previous() !!}", 1500);
					  },
					 error: function(xhr, textStatus, error)
					  {
						stopLoadingOverlay("loading_overlay");  
						popupshow($.parseJSON(xhr.responseText),'error');
					  }				  
				});
			}
});
</script>
{{-- -------------------------------------------- --}}
</div>
<div class="clear"></div> 

</div> 
@stop
<div class="clear"></div> 
