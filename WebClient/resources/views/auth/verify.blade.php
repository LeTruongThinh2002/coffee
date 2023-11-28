@extends('shared.layout')
@section('body')
@if(isset($msg))
    <div class="text-light">{{$msg}}</div>
@else
    <div class="text-light">Xác thực không thành công do yêu cầu xác thực quá lâu!</div>
@endif
@endsection