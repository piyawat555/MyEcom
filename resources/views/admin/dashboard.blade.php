@extends('admin.layout')
@section('page_title','DashBoard')
@section('dashboard_select','active')
@section('container')

<div class="row">
    <h3>DashBoard</h3>
</div>
@if (session('loginsuccess'))
<div class="pt-5">

</div>
<div class="alert alert-success">
    <strong>{{session('loginsuccess')}}</strong>
     <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
@endif
@endsection