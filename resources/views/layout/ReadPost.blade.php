@extends('layout.Template')

@if (isset($post->title))
	@section('title')
	{{ $post->title." - ".trans('layout/template.title') }}
    @stop
@endif 
@section('hstyle')
    {!! HTML::style('css/fallr/jquery-fallr-1.3.css') !!}
    {!! HTML::style('css/validators/validationEngine.jquery.css') !!}
@stop
@section('bscript')
    {!! HTML::script('js/fallr/fallr1.3.js') !!}
    {!! HTML::script('js/utility/popup.js') !!}
    {!! HTML::script('js/validators/jquery.validationEngine.js') !!}
    {!! HTML::script('js/validators/languages/jquery.validationEngine-fa_3.js') !!}
    {!! HTML::script('js/validators/customValidators_3.js') !!}
    
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("#commentform").validationEngine();
});
</script> 
@stop 
@section('content')
<div id="content">
	<div id="rightbarleft">@include('layout.rightbar')</div>
    <div id="articlebarright">
{{-- -------------------------------------------- --}}
		<div class="Blkarticle single">
         	 {!! link_to('#',$post->title,['class' => 'title']) !!}
    		<ul class="postcategories visitcnt">
				<li>
          			{!! link_to('#',$post->seen." ".trans('layout/template.seen'),['rel' => 'category tag']) !!}
        		</li>
    		</ul>
    		<div class="Blkarticletools">
				<span class="Blkarticledate">
        	 	{{ $post->JalaliCreate_at }}     
				</span>
				<a href="#" rel="nofollow" target="_blank" class="twitter">&nbsp;</a>
				<a href="#" rel="nofollow" target="_blank" class="facebook">&nbsp;</a>
				<a href="#" rel="nofollow" target="_blank" class="google">&nbsp;</a>
    		</div>
            <div class="Blkarticlecontent">
                {!! $post->content !!}
            </div>
			<div class="clear"></div>
			<div class="catagorytag">
				<ul>
          			<li class="undercatagorytag">{{ trans('layout/template.catagory') }}</li>
          			<li>
          				{!! link_to('catagory/'.$post->tag,trans('layout/headermenu.'.$post->tag),['target' => '_blank']) !!}
         			</li>                                    
				</ul>
      			<div class="clear"></div>
    		</div>
    		<div class="clear"></div>
			</div>
            <div class="commentarea">                          
                <h3 id="comments">{{ trans('layout/template.comments') }}</h3>
                <div class="navigation">
                    <div class="alignleft"></div>
                    <div class="alignright"></div>
                </div>
            <!--Start of Comments -->
                <ol class="commentlist">
                    @foreach($comments as $comment)
                        <li class="comment even" id="{{ $comment->cmt_id }}">
                            <div class="commentbody">
                                <div class="commentauthor vcard">
                                    <img alt='' src='http://0.gravatar.com/avatar/cf64731220269ce7281fe84b61976450?s=32&amp;d=wavatar&amp;r=G' class='avatar photo' height='32' width='32' />
                                    <cite class="fn">{{ $comment->commenter }}</cite>
                                    <span class="says">:</span>
                                </div>
                                <div class="commentmeta commentmetadata">
                                    <a href="#{{ $comment->cmt_id }}">{{ trans('layout/template.indate').":".$comment->JalaliCreate_at." - ".$comment->JalaliCreateTime  }}</a>
                                </div>
                                <p>{{ $comment->comment }}</p>
                            </div>
                    	</li>
                    @endforeach    
            <!--end of Comments -->
                </ol>
                <div class="navigation">
                    <div class="alignleft"></div>
                    <div class="alignright"></div>
                </div>
                <div id="respondarea">
                	<h3>{{ trans('layout/template.commentarea') }}</h3>
                    {!! Form::open(['route' => 'insertComment', 'method' => 'POST', 'class' => 'search' , 'id' => "commentform"]) !!}
                    
                    {!!Form::text('commenter','',['id'=>'commenter' , 'class'=>'validate[required] i-text' , 'aria-required'=>'true' , 'size'=>'22'])!!}
                    {!!Form::label('commenter',trans('layout/template.commentername'))!!}
                    <small>{{trans('layout/template.necessary') }}</small>
                    <p>
                    {!!Form::text('email','',['id'=>'email' , 'class'=>'validate[required] i-text' , 'aria-required'=>'true' , 'size'=>'22'])!!}
                    {!!Form::label('email',trans('layout/template.commenteremail'))!!}
                    <small>{{trans('layout/template.necessary') }}</small>
                    <p>
                    {!! Form::textarea('comment', '' , ['class'=>'validate[required] i-text' , 'cols'=>'58', 'rows'=>'10' , 'id'=>'comment']) !!}
                    <p>
                    {!! Form::submit(trans('layout/template.submitcomment') , ['id'=>'submitcomment']) !!}
                    {!! Form::hidden('pst_id',$post->pst_id) !!}
                    {!! Form::close() !!}
                </div>
            </div>
{{-- -------------------------------------------- --}}
<script type="text/javascript">

$("#commentform").submit(function (e){
										   
             // Stop form from submitting normally
			 e.preventDefault();
			if ($(this).validationEngine('validate'))
			{
				var $this = $(this);
				var url = $this.attr('action');
			    $.ajax({
					url: url,
					type: 'POST',
					dataType: 'JSON',
					data: $this.serialize(),
					success: function(data)
					  {
	popupshow("{!!trans('layout/template.succ').'<br>'.trans('layout/template.viewafteradminaccept')!!}",'succ');
						$("#commentform .i-text").val('');
					  },
					 error: function(xhr, textStatus, error)
					  {
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