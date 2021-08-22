@extends('admin.layout')
@section('page_title','Category')
@section('category_select','active')
@section('container')
@if (session('message'))
<div class="alert alert-success" role="alert">
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@elseif (session('messagedelete'))
<div class="alert alert-danger" role="alert">
    {{session('messagedelete')}}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif
  <h1 class="mb10">CateGory</h1>
  <a href="{{route('manage_category')}}">
    <button type="button" class="btn btn-success">Add Category</button>
  </a>
  
  <div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Category Slug</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $list)
                    <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->category_name}}</td>
                        <td>{{$list->category_slug}}</td>
                        @if ($list->status==0)
                        <td id="clossingcolor">ปิดอยู่</td>
                        @elseif ($list->status==1)
                        <td id="opencolor">กำลังเปิดอยู่</td>
                        @endif
                        <td>
                            <a href="category/{{$list->id}}/edit"><button type="button" class="btn btn-warning">แก้ไข</button></a>
                            <a href="{{route('admin.delete',$list->id)}}"><button type="button" class="btn btn-danger">ลบ</button></a>
                            @if ($list->status==0)
                            <a href="{{url('admin/category/status/1')}}/{{$list->id}}"> <button type="button" class="btn btn-success">เปิด</button></a>
                                @elseif ($list->status==1)
                            <a href="{{url('admin/category/status/0')}}/{{$list->id}}"> <button type="button" class="btn btn-primary">ปิด</button></a>
                                @endif
                            
                        </td>
                       
                      
                    </tr>
                    @endforeach
                    
                   
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>



@endsection