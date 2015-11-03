    	@foreach($posts as $post)
    		<ul class="listposts" id="dv{{ $post->pst_id }}"> 
            		<li class="chk" >
                     <input tabindex="1" type="checkbox" name="selectchk[{{$post->pst_id}}]" id="{{$post->pst_id}}" value="{{$post->pst_id}}" class="chkbox" />

                    </li>  
                	<li class='title'>
            {!! link_to(route('adminReadPost',$post->pst_id),$post->title,['class' => 'title' , "target" => "_blank"]) !!}
                    </li>
            
                	<li class="tag">
                    	{{trans('layout/headermenu.'.$post->tag) }}
                    </li>
                	<li class="update_at">
                    	{{ $post->JalaliUpdated_at }}
                    </li>                                                           
                    <li class="btn0">
                      <?php
					 if($post->active)
					 {
					$Msg=trans('admin/template.notactive');
					$Conent=trans('admin/template.notactiveconfirm');						
					 $dellnk=htmlspecialchars_decode("open_modal('updateActive( \'".route('updateActive')."\' ,".$post->pst_id.",\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'false\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
					 echo '<a href="#" class="editbtn prevent" onclick="';
					 echo $dellnk;
					 echo '">'.trans('admin/template.notactive').'</a>';
					 }
					 else
					 {
					$Msg=trans('admin/template.active');
					$Conent=trans('admin/template.activeconfirm');						
					 $dellnk=htmlspecialchars_decode("open_modal('updateActive( \'".route('updateActive')."\' ,".$post->pst_id.",\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'true\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
					 echo '<a href="#" class="editbtn prevent" onclick="';
					 echo $dellnk;
					 echo '">'.trans('admin/template.active').'</a>';						 
					 }
					   ?>
                     </li>
					<li class="btn0">
                    <?php
						$Msg=trans('admin/template.delete');
						$Conent=trans('admin/template.delconfirm');						
						 $dellnk=htmlspecialchars_decode("open_modal('Delete( \'".route('deletePost')."\' ,".$post->pst_id.",\'".csrf_token()."\',\'".trans('layout/template.succ')."\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
						 echo '<a href="#" class="deletebtn prevent" onclick="';
						 echo $dellnk;
						 echo '">'.trans('admin/template.delete').'</a>';					
					?>
                    </li>                     
                	<li class="btn0">
                        @if($post->active)
                          {!! link_to(route('editPostForm',"$post->pst_id"),trans('admin/template.edit'),['class' => 'viewbtn']) !!}
                        @endif                        
                    </li>                                                            
            </ul>             
 			<div class="clear"></div>              
        @endforeach
<div class="clear">&nbsp;</div>
        