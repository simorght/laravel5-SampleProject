@extends('layout.Template')
@section('title')
	{{ trans('layout/template.login')." - ".trans('layout/template.title') }}
@stop

@section('content')
<div id="content">
	<div id="rightbarleft">&nbsp;</div>
    <div id="articlebarright">
{{-- -------------------------------------------- --}}
<div class="Blkarticle single normlizeheigh">
          {!! link_to('#',trans('layout/template.login'),['class' => 'title']) !!}
    <div class="Blkarticlecontent loginformtop" >
		<form action="{{ url('auth/login') }}" method="POST" ><input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label for="user_name">{{trans('layout/template.user_name') }}</label>
        <input type="text" value="@if(old('user_name')!=null){{ old('user_name')}}@endif" name="user_name" id="user_name" />
        <div class="clearh"></div>
        <label for="password">{{trans('layout/template.password') }}</label>        
        <input type="password" value="" name="password" id="password" />
        <div class="clearh"></div>
        <input type="checkbox"  value="0" id="remember"  name="remember" />
        {{ trans('layout/template.remember') }}
        <div class="clearh"></div>
        <input type="submit" class="downloadbtn noborderbtn" value="{{ trans('layout/template.loginform') }}"></p>
        </form>
     	<small class="red">
				@if(session()->has('error'))
					{{  session('error') }}
				@endif                
        </small>        	        
	</div>
    <div class="clear"></div>
    </div>
    </div>
 <div class="clear"></div>  
</div>
@stop