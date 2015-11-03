<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<head>
    	<meta name="csrf_token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Lang" content="en" />
        <meta name="author" content="Samad Soltanzad" />
        <meta http-equiv="Reply-to" content="Soltanzad@engineer.com" />
        <meta name="generator" content="Samad Soltanzad" />
		<title>@yield('title', trans('layout/template.title') ) </title>
		<meta name="description" content= {!! trans('layout/template.descriptioncontent') !!} />

		<meta name="keywords" content= {!! trans('layout/template.keywordscontent') !!} />

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
						<li>{!! link_to('/admin', trans('admin/template.index')) !!}</li>                        
						<li>{!! link_to('/auth/logout', trans('admin/template.logout')) !!}</li>                        
                    </ul>
                    <form method="get" id="searchform" class="search"  action="{{ route('search') }}">
  <div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">  
        <input type="text" onblur="if(this.value=='')this.value='{!! trans('layout/template.searchinsite') !!}'" onfocus="if(this.value=='{!! trans('layout/template.searchinsite') !!}')this.value=''" name="q" id="q" value="{!! trans('layout/template.searchinsite') !!}"  />
        <input type="submit" id="searchsubmit" value="{!! trans('layout/template.search') !!}" />
  </div>
</form>                    
                                        
                </div>
        </div>
{{-- end of top menu --}} 
   
{{-- begin of header --}}
    	<div id="header">
                <div class="logo">
                    <h3>{!! trans('layout/template.blog') !!}</h3>
                    <h1>{!! link_to('/', trans('layout/template.auther')) !!}</h1>
                    <h2>{!! trans('layout/template.job') !!}</h2>
                </div>
{{-- begin of social --}}
{{-- end of social --}}  
                <div class="clear"></div>
                <div class="mainnavigation">
                    <ul>
     <li>
     <a href="{!! url('admin/posts') !!}" title="{!! trans('admin/headermenu.link1') !!}" @if (Route::current()->getName() == 'listPosts') {!! 'class=active' !!} @endif >{!!  trans('admin/headermenu.link1') !!}</a>
     </li>
     
     <li>
     <a href="{!! url('admin/comments') !!}" title="{!! trans('admin/headermenu.link2') !!}" @if (Route::current()->getName() == 'listComments') {!! 'class=active' !!} @endif >{!!  trans('admin/headermenu.link2') !!}</a>     
     </li>

     <li>
     <a href="{!! url('admin/files') !!}" title="{!! trans('admin/headermenu.link3') !!}" @if (Route::current()->getName() == 'medias') {!! 'class=active' !!} @endif >{!!  trans('admin/headermenu.link3') !!}</a>     
     </li> 
     
     
         
     <li>{!! link_to('admin/users', trans('admin/headermenu.link4'), ['title' =>  trans('admin/headermenu.link4')]) !!}</li>     
     
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
<!-- Loading_overlay -->
{!! HTML::script('js/util/loadingGifUtil.js') !!}
<script type="text/javascript">
    //--AutoHide
    $('#loading_overlay').live('mouseover mouseout', 
        function(event) {
            if(event.type == 'mouseover'){$('#close_overlay').css("color","#000");}
            else {$('#close_overlay').css("color","#eee");}
        }
    );
</script>
<div id="loading_overlay" align="center" dir="rtl" style="width:170px;height:80px;z-index:9999;display:none;">
    <div class="ui-widget-shadow ui-corner-all" style="width:171px;height:81px;position:absolute;"></div>
    <div style="position:absolute;width:150px;height:60px;padding:10px;margin:0px 7px 6px 0px;" class="ui-widget ui-widget-content ui-corner-all">
        <div class="ui-dialog-content ui-widget-content" style="background:none;border:0;">
            <div id="close_overlay" onClick="stopLoadingOverlay('loading_overlay');" style="float:right;margin-top:-5px;cursor:pointer;color:#eee;">x</div>
            <!-- Loading indicator -->
            {!! HTML::image('images/loading_img.gif' ,'', [ 'border' => '0' , 'style' => 'margin-right:-5px;']) !!}
            <!-- /Loading indicator -->
            <p>{!!  trans('layout/template.loading') !!}</p>
        </div>
    </div>
</div>
<!-- /Loading_overlay -->
{!! HTML::script('js/utility/footerPosition.js') !!}
  </body>
</html>