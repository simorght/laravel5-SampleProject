<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<head>
    	<meta name="csrf_token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Samad Soltanzad" />
        <meta http-equiv="Reply-to" content="Soltanzad@engineer.com" />
        <meta name="generator" content="Samad Soltanzad" />
		<title>@yield('title', trans('layout/template.title') ) </title>
		<meta name="description" content= {{ trans('layout/template.descriptioncontent') }} />

		<meta name="keywords" content= {{ trans('layout/template.keywordscontent') }} />

		<meta name="viewport" content="width=device-width, initial-scale=1">

		@yield('head')

		{!! HTML::style('css/normalize.css') !!}
		{!! HTML::style('css/print.css') !!}
		{!! HTML::style('style.css') !!}
		{!! HTML::style('css/codecolorere2dc.css?ver=0.9.9') !!}
        
		@yield('hstyle')
        
		{!! HTML::script('js/jquery-1.8.2.min.js') !!}
        
		@yield('hscript')
        
        
	</head>
  <body>
	<div id="page">
{{-- begin of top menu --}}    
    	<div id="tmenu">
                <div id="tmwr">
                    <ul class="topmenu">
						<li>{!! link_to('/', trans('layout/template.index')) !!}</li> 
						<li>{!! link_to('aboutme', trans('layout/template.aboutme')) !!}</li> 
						<li>{!! link_to('resume', trans('layout/template.resume')) !!}</li> 
						<li>{!! link_to('corporate', trans('layout/template.corporate')) !!}</li> 
						<li>{!! link_to('contact', trans('layout/template.contact')) !!}</li> 
                        @if(session('name')!=NULL)
                            <li>
                            {!! link_to('admin/' , trans('layout/template.login')." (".session('name').")") !!}
                            </li>
                            <li>
                            {!! link_to('auth/logout' , trans('layout/template.logout')) !!}
                            </li>                        
                        @else
                            <li>
                            {!! link_to('auth/login', trans('layout/template.login')) !!}
                            </li>
                        @endif
                        </li>                       
                    </ul>
                    {!! Form::open(['route' => 'search', 'method' => 'GET', 'class' => 'search' , 'id' => "search"]) !!}
                    <div>
                      {!!Form::text('q',trans('layout/template.searchinsite'),['id'=>"q"])!!}
                      
                      <script type="text/javascript">$('#q').blur(function(){if(this.value=="")this.value="{{trans('layout/template.searchinsite')}}"}).focusin(function(){if(this.value=="{{trans('layout/template.searchinsite')}}")this.value=''});</script>
                      
                      {!! Form::submit( 'searchsubmit' , ['id' => 'searchsubmit']) !!}
 					</div>
                    {!! Form::close() !!}  
                                        
                </div>
        </div>
{{-- end of top menu --}} 
   
{{-- begin of header --}}
    	<div id="header">
                <div class="logo">
                    <h3>{{ trans('layout/template.blog') }}</h3>
                    <h1>{!! link_to('/', trans('layout/template.auther')) !!}</h1>
                    <h2>{{ trans('layout/template.job') }}</h2>
                </div>
{{-- begin of social --}}

{{-- end of social --}}  
                <div class="clear"></div>
                <div class="mainnavigation">
                    <ul>
                    
                         <li><a href="{!! url('tag/link1') !!}" title="{{ trans('layout/headermenu.link1') }}" @if (Request::is('tag/link1')) {!! 'class=active' !!} @endif >{{  trans('layout/headermenu.link1') }}</a></li>

                         <li><a href="{!! url('tag/link2') !!}" title="{!! trans('layout/headermenu.link2') !!}" @if (Request::is('tag/link2')) {!! 'class=active' !!} @endif >{{  trans('layout/headermenu.link2') }}</a></li>

                         <li><a href="{!! url('tag/link3') !!}" title="{!! trans('layout/headermenu.link3') !!}" @if (Request::is('tag/link3')) {!! 'class=active' !!} @endif >{{  trans('layout/headermenu.link3') }}</a></li>

                         <li><a href="{!! url('tag/link4') !!}" title="{!! trans('layout/headermenu.link4') !!}" @if (Request::is('tag/link4')) {!! 'class=active' !!} @endif >{{  trans('layout/headermenu.link4') }}</a></li>

                         <li><a href="{!! url('tag/link5') !!}" title="{!! trans('layout/headermenu.link5') !!}" @if (Request::is('tag/link5')) {!! 'class=active' !!} @endif >{{  trans('layout/headermenu.link5') }}</a></li>

                         <li><a href="{!! url('tag/link6') !!}" title="{!! trans('layout/headermenu.link6') !!}" @if (Request::is('tag/link6')) {!! 'class=active' !!} @endif >{{  trans('layout/headermenu.link6') }}</a></li>
     
                    </ul>
                    
                </div>
            </div>
{{-- end of header --}} 

{{-- begin of content --}}

@yield('content')

{{-- end of content --}} 

{{-- begin of footer --}}
        <div id="footer">
                        <div id="footerwr">
                            <span class="copyright">{!!  trans('layout/template.copyright') !!}{!!  trans('layout/template.legal') !!}</span>
                            <a href="#" class="go_top"></a>
                        </div>
        </div>    
{{-- end of footer --}}    
        
    </div>
@yield('bscript')  
{!! HTML::script('js/utility/footerPosition.js') !!}
  </body>
</html>