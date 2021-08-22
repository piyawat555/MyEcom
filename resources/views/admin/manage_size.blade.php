@extends('admin.layout')

@section('container')
@section('page_title','Manage Size')
@section('size_select','active')
  <h1 class="md10">Manage Size</h1>
  <a href="{{URL::to('admin/size')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  
  <div class="row m-t-30">
    <div class="col-md-12">
            
                <div class="col-lg-12">
                    {{session('message')}}
                    <div class="card">                    
                        <div class="card-body">
                            
                            <form action="{{route('size.insert')}}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="size" class="control-label mb-1">Size</label>
                                    <input id="size" name="size" type="text" value="{{$size}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('size')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                     
                                    @enderror
                                </div>
                           
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        เพิ่มข้อมูล  
                                    </button>
                                </div>
                                <input type="hidden" name="id" value="{{$id}}">
                            </form>
                        </div>
                    </div>
                </div>
                
           
    </div>
</div>



@endsection