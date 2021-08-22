
@extends('admin.layout')

@section('container')
@section('page_title','Home Banner')
@section('home_banner_select','active')
  <h1 class="md10">Home Banner</h1>
  <a href="{{URL::to('admin/home_banner')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  <div class="row m-t-30">
    <div class="col-md-12">
            
                <div class="col-lg-12">
                    {{session('message')}}
                    <div class="card">                    
                        <div class="card-body">
                            
                            <form action="{{route('home_banner.insert')}}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                       <div class="col-md-6">
                                        <label for="btn_txt" class="control-label mb-1">Btn Text</label>
                                        <input id="btn_txt" name="btn_txt" type="text" value="{{$btn_txt}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('btn_txt')
                                        <div class="alert alert-danger" role="alert">
                                            {{$message}}
                                        </div>
                                         @enderror
                                       </div>
                                       <div class="col-md-6">
                                        <label for="btn_link" class="control-label mb-1">Btn Link</label>
                                        <input id="btn_link" name="btn_link" type="text" value="{{$btn_link}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('btn_link')
                                        <div class="alert alert-danger" role="alert">
                                            {{$message}}
                                        </div>
                                         @enderror
                                        </div> 
                                    </div>
                               </div>
                          
                               <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="image" class="control-label mb-1">Image</label>
                                        <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false">
                                        @if ($image!='')
                                        
                                       <a href="{{asset('storage/media/banner/'.$image)}}" target="_blank"><img width="100px" src="{{asset('storage/media/banner/'.$image)}}" alt=""></a> 
                                       @endif 
                                      
                                        @error('image')
                                        <div class="alert alert-danger" role="alert">
                                           {{$message}}		
                                        </div>
                                        @enderror
                                    </div>
                                 </div>
                                </div>

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