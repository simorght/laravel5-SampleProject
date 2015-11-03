    	@foreach($comments as $comment)
<?php if($comment->seen==0) $seen='unseen'; else $seen=''; ?>
    		<ul class="listposts <?php echo $seen;?>" id="dv{{ $comment->cmt_id }}"> 
            		<li class="chk" >
                     <input tabindex="1" type="checkbox" name="selectchk[{{$comment->cmt_id}}]" id="{{$comment->cmt_id}}" value="{{$comment->cmt_id}}" class="chkbox" />

                    </li>  
                	<li class='title'>
            @if($comment->pst_id)      
            {!! link_to('post/'.$comment->pst_id,$comment->title,['class' => 'title' , "target" => "_blank"]) !!}
            @endif
                    </li>
            
                	<li class="email">
                    	{{ $comment->email }}
                    </li>
                	<li class="update_at">
                    	{{ $comment->JalaliUpdated_at }}
                    </li>                                       
                    <li class="btn0">
                      <?php
					 if($comment->approved==1)
					 {	 
					$Msg=trans('admin/template.noneaccpet');
					$Conent=trans('admin/template.noacccmtconfirm');						
					 $actlnk=htmlspecialchars_decode("open_modal('UpdateApproved( \'".url('admin/updatespprove/'.$comment->cmt_id)."\' ,".$comment->cmt_id.",\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'0\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
					 echo '<a href="#" class="deletebtn prevent" onclick="';
					 echo $actlnk;
					 echo '">'.trans('admin/template.noneaccpet').'</a>';					 
					 }
					 else
					 {
						 
					$Msg=trans('admin/template.accpet');
					$Conent=trans('admin/template.acccmtconfirm');						
					 $actlnk=htmlspecialchars_decode("open_modal('UpdateApproved( \'".url('admin/updatespprove/'.$comment->cmt_id)."\' ,".$comment->cmt_id.",\'".csrf_token()."\',\'".trans('layout/template.succ')."\',\'1\')','".$Msg."','".$Conent."');", ENT_NOQUOTES);
					 echo '<a href="#" class="editbtn prevent" onclick="';
					 echo $actlnk;
					 echo '">'.trans('admin/template.accpet').'</a>';						 
					 }
					   ?>
                     </li>
					<li class="btn0">
                      {!! link_to('#',trans('admin/template.view'),['class' => 'viewbtn' , 'cmt_id' => $comment->cmt_id]) !!}
                    
                    </li>                                                              
            </ul>             
 			<div class="clear"></div>              
        @endforeach       
<div class="clear">&nbsp;</div>   