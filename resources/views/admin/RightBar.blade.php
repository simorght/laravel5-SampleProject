<div class="block">
    <h3 class="title">{!! trans('admin/template.statics') !!}</h3>
    <div class="block_content">
        <ul>
           <li>
           		<a href="#">
                {!! trans('admin/template.staticlogin') !!}                <span class="date">{!! session('last_login_at') !!}</span>
                </a>
           </li>
           <li>
                <a href="#">
                {!! trans('admin/template.staticcomments') !!}                <span class="send">{!! $nbrComments['total'] !!}</span>
                </a>
           </li>
           <li>
                <a href="#">
                {!! trans('admin/template.staticcommentsnonview') !!}             <span class="view">{!! $nbrComments['new'] !!}</span>
                </a>
           </li>
           <li>
                <a href="#">
                {!! trans('admin/template.staticposts') !!}                <span class="send">{!! $nbrPosts['total'] !!}</span>
                </a>
           </li>                                             
        </ul>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>