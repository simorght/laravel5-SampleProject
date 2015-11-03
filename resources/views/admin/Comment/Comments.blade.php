@extends('admin.Template')  
@section('title')
{{ trans('admin/headermenu.link2')." - ".trans('admin/template.title') }}
@stop
@section('hstyle')
    {!! HTML::style('css/fallr/jquery-fallr-1.3.css') !!}
    {!! HTML::style('css/validators/validationEngine.jquery.css') !!}
    {!! HTML::style('css/jquery-ui-1.8.16.custom.css') !!}
    {!! HTML::style('css/element/jqueryui_button/jquery.ui.button.min.css') !!}
    {!! HTML::style('css/element/jqueryui_dialog/jquery.ui.dialog.min.css') !!}    
@stop

@section('bscript')
    {!! HTML::script('js/fallr/fallr1.3.js') !!}
    {!! HTML::script('js/utility/popup.js') !!}
    {!! HTML::script('js/validators/jquery.validationEngine.js') !!}
    {!! HTML::script('js/validators/languages/jquery.validationEngine-fa_3.js') !!}
    {!! HTML::script('js/validators/customValidators_3.js') !!}
    {!! HTML::script('js/jquery-ui-1.9.0.custom.min.js')!!}
@stop
@section('content')
@section('hscript')
    <script type="text/javascript">
    $('#modal_OnlyText').dialog({autoOpen: false,modal: true,draggable: true,});
    </script>
@stop 
@section('bscript')
    {!! HTML::script('js/update/comments.js')!!}
    @include('admin.Modal', array('Msg'=>trans('admin/template.delete') , 'Fn' => '' , 'Conent' => trans('admin/template.delconfirm' )))
@append                   
@include('admin.Comment.CommentsListForEdit')
@stop