@extends('shared.layout')
@section('body')
@section('class-body')
    id="theme8" style="color:black !important;"
@endsection
@if(isset($msg))
    <!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">{{$msg}}</h1>
        </div>
        <!-- Single Page Header End -->
@else
     <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Email validation successfully!</h1>
        </div>
        <!-- Single Page Header End -->
@endif
@endsection