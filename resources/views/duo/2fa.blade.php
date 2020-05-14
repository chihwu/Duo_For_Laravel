@extends('layouts.duo')
 
@section('content')
    <div id="duo">
        <h2>Duo: Two Factor Authentication</h2>
        <iframe id="duo_iframe" frameborder="0">
 
        </iframe>
        <form method="post" id="duo_form">
            {{csrf_field()}}
        </form>
    </div>
@stop
 
 
@section('js')
    <script type="application/javascript" src="{{asset('js/duo/Duo-Web-v2.min.js')}}"></script>
    <script type="application/javascript">
        Duo.init({
            'host'       : "{{$host}}",
            'sig_request': "{{$sig_request}}",
            'post_action': "{{$post_action}}"
        });
    </script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/duo/duo.css')}}">
@endsection
