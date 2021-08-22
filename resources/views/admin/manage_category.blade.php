
@extends('admin.layout')

@section('container')
@section('page_title','Manage CateGory')
@section('category_select','active')
  <h1 class="md10">Manage CateGory</h1>
  <a href="{{URL::to('admin/category')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  <div class="row m-t-30">
    <div class="col-md-12">
            
                <div class="col-lg-12">
                    {{session('message')}}
                    <div class="card">                    
                        <div class="card-body">
                            
                            <form action="{{route('category.insert')}}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                       <div class="col-md-4">
                                        <label for="category_name" class="control-label mb-1">CateGory</label>
                                        <input id="category_name" name="category_name" type="text" value="{{$category_name}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('category_name')
                                        <div class="alert alert-danger" role="alert">
                                            {{$message}}
                                        </div>                                   
                                        @enderror
                                       </div>
                                       <div class="col-md-4">
                                        <label for="parent_category_id" class="control-label mb-1">Parent Category</label>
                                         <select id="parent_category_id" name="parent_category_id" class="form-control" required>
                                            <option value="0">Select Categories</option>
                                            @foreach($category as $list)
                                            @if($parent_category_id==$list->id)
                                            <option selected value="{{$list->id}}">
                                               @else
                                            <option value="{{$list->id}}">
                                               @endif
                                               {{$list->category_name}}
                                            </option>
                                            @endforeach
                                         </select>
                                        </div> 

                                       <div class="col-md-4">
                                        <label for="category_slug" class="control-label mb-1">CateGory Slug</label>
                                        <input id="category_slug" name="category_slug" type="text" value="{{$category_slug}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('category_slug')
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
                                        <label for="category_image" class="control-label mb-1">Image</label>
                                       
                                        <input id="category_image" name="category_image" type="file" class="form-control" aria-required="true" aria-invalid="false">
                                        @if ($category_image!='')
                                        
                                       <a href="{{asset('storage/media/category/'.$category_image)}}" target="_blank"><img width="100px" src="{{asset('storage/media/category/'.$category_image)}}" alt=""></a> 
                                       @endif 
                                      
                                        @error('category_image')
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
                                <input type="hidden" name="id" value="{{$id}}">
                               
                            </form>
                        </div>
                    </div>
                </div>
                
           
    </div>
</div>



@endsection