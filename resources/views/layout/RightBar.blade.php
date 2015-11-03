<div class="block">
    <h3 class="title favorit">{{ trans('layout/template.favorit') }}</h3>
    <div class="block_content">
        <ul>
        @foreach($mostLikePostsList as $mostLikePost)
           <li>
             <a href="{!! url('post/'.$mostLikePost->pst_id) !!}">
                {{ $mostLikePost->title }}                
                <span class="send">
                 {{ $mostLikePost->aggregate." ".trans('layout/template.comment') }}  
                </span>
             </a>
           </li>
        @endforeach        
        </ul>
    </div>
    <div class="clear"></div>
</div>
<div class="block">
    <h3 class="title newest">{{ trans('layout/template.newest') }}</h3>
    <div class="block_content">
        <ul>
        @foreach($newPostsList as $newPost)
           <li>
             <a href="{!! url('post/'.$newPost->pst_id) !!}">
                {{ $newPost->title }}                
                <span class="date">
                 {{ $newPost->JalaliCreate_at." - ".$newPost->JalaliCreateTime }}  
                </span>
             </a>
           </li>
        @endforeach
        </ul>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>