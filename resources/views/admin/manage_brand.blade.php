@extends('admin.layout')

@section('container')
@section('page_title','Manage Brand')
@section('brand_select','active')


  <h1 class="md10">Manage Brand</h1>
  <a href="{{URL::to('admin/brand')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  
  <div class="row m-t-30">
    <div class="col-md-12">
            
                <div class="col-lg-12">
                    {{session('message')}}
                    <div class="card">                    
                        <div class="card-body">
                            
                            <form action="{{route('brand.insert')}}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="control-label mb-1">Brand</label>
                                    <input id="name" name="name" type="text" value="{{$name}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('name')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                     
                                    @enderror
                                </div>   
                                <div class="form-group">
                                    <label for="image" class="control-label mb-1"> Image</label>
                                    <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false">
                                    
                                    @if ($image!='')
                                        
                                       <a href="{{asset('storage/media/brand/'.$image)}}" target="_blank"><img width="100px" src="{{asset('storage/media/brand/'.$image)}}" alt=""></a> 
                                       @endif 
                                       @error('image')
                                       <div class="alert alert-danger" role="alert">
                                          {{$message}}
                                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       </div>   
                                       @enderror
                                  
                                       @error('image.*')
                                       <div class="alert alert-danger" role="alert">
                                          {{$message}}
                                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                                       </div>   
                                       @enderror
                                 </div>  
                                 <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="is_home" class="control-label mb-1">Show in Home Page</label>
                                            <input id="is_home" name="is_home" type="checkbox" {{$is_home_selected}}>
                                        </div>
                                     </div>
                                    </div>            
                                <div>
                              
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        เพิ่มข้อมูล  
                                    </button>
                                </div>
                                <input type="hidden" name="status" value="{{$status}}">
                                <input type="hidden" name="id" value="{{$id}}">
                            </form>
                        </div>
                    </div>
                </div>
                
           
    </div>
</div>



@endsection