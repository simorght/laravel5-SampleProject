@extends('layout.Template')    
@if (isset($tag))
	@section('title')
	{{ trans('layout/headermenu.'.$tag)." - ".trans('layout/template.title') }}
    @stop
@endif 
@section('content')
<div id="content">
	<div id="rightbarleft">@include('layout.rightbar')</div>
    <div id="articlebarright">
    	@foreach($posts as $post)
        	<div class="Blkarticle">
            {!! link_to(route('readPost',$post->pst_id),$post->title,['class' => 'title']) !!}
                <ul class="postcategories">
                	<li>
                    	{{ $post->Comment->count()." ".trans('layout/template.comment') }}
                    </li>
                </ul>
				<div class="Blkarticletools">
                   <a href="{!! url('post/'.$post->pst_id) !!}" class="BlkarticlereadMore">
                   		&nbsp;
                   </a>
                   <span class="Blkarticledate">
                       {{ $post->JalaliCreate_at }}
                   </span>
                </div>
                <div class="Blkarticlecontent">
                   <p>{!! $post->read_more !!}</p>
                </div>
                <div class="clear"></div>          
                <br />                
            </div>               
        @endforeach
        {!! $links !!}
    </div>          
 <div class="clear"></div> 
</div>
@stop 