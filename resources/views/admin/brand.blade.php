@extends('admin.layout')
@section('page_title','Brand')
@section('brand_select','active')
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
  <h1 class="mb10">Brand</h1>
  <a href="{{route('manage_brand')}}">
    <button type="button" class="btn btn-success">Add Brand</button>
  </a>
  
  <div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $list)
                    <tr>
                        <td>{{$list->id}}</td>
                        <td>{{$list->name}}</td>
                      
                        @if ($list->image!='')
                                        
                        <td> <a href="{{asset('storage/media/brand/'.$list->image)}}" target="_blank"><img width="100px" src="{{asset('storage/media/brand/'.$list->image)}}" alt=""></a></td> 
                        @endif 
                       
                         @error('image')
                         <div class="alert alert-danger" role="alert">
                            {{$message}}		
                         </div>
                         @enderror  
                        @if ($list->status==0)
                            <td id="clossingcolor">ปิดอยู่</td>
                        @elseif($list->status==1)
                        <td id="opencolor">กำลังเปิดอยู่</td>
                        @endif
                        
                        <td>
                            <a href="brand/{{$list->id}}/edit"><button type="button" class="btn btn-warning">แก้ไข</button></a>
                            <a href="{{route('admin.delete.brand',$list->id)}}"><button type="button" class="btn btn-danger">ลบ</button></a>
                            @if ($list->status==0)
                            <a href="{{url('admin/brand/status/1')}}/{{$list->id}}"> <button type="button" class="btn btn-success">เปิด</button></a>
                                @elseif ($list->status==1)
                            <a href="{{url('admin/brand/status/0')}}/{{$list->id}}"> <button type="button" class="btn btn-primary">ปิด</button></a>
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