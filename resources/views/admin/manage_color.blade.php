@extends('admin.layout')

@section('container')
@section('page_title','Manage Color')
@section('color_select','active')
  <h1 class="md10">Manage Color</h1>
  <a href="{{URL::to('admin/color')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  
  <div class="row m-t-30">
    <div class="col-md-12">
            
                <div class="col-lg-12">
                    {{session('message')}}
                    <div class="card">                    
                        <div class="card-body">
                            
                            <form action="{{route('color.insert')}}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="color" class="control-label mb-1">Color</label>
                                    <input id="color" name="color" type="text" value="{{$color}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('color')
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