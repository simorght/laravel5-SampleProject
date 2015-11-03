<!--dialogs -->
<div id="modal_OnlyText" style="display:none;" title="">
<form id="frmText" name="frmText" method="post" ><div class="section-input" id="Text_Main" style="padding-right:50px">{{ $Conent }}</div><div class="clearfix"></div></form></div>
<!--dialogs -->
<script type="text/javascript">
function open_modal(Fn,msg,Conent)
{
	$( "#modal_OnlyText" ).dialog({ resizable: false, title:msg , width:350,buttons: {"{{ trans('admin/template.close') }}": function(){$( this ).dialog( "close" );},btnFn: function(){eval(Fn);},}});
	$('.ui-dialog-buttonpane button:contains(btnFn)').button('option', 'label', msg);
	$("#Text_Main").html(Conent);
}

function open_modal_WF(msg,Conent)
{
	$( "#modal_OnlyText" ).dialog({ resizable: false, title:msg , width:500,buttons: {"{{ trans('admin/template.close') }}": function(){$( this ).dialog( "close" );}}});
	$("#Text_Main").html(Conent);
}
</script>