 @extends('admin.layout')

@section('container')
@section('page_title','Manage Product')
@section('product_select','active')
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
@elseif (session('sku_error'))
<div class="alert alert-danger" role="alert">
    {{session('sku_error')}}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif
@error('attr_image.*')
<div class="alert alert-danger" role="alert">
   {{$message}}
   <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>   
@enderror

@error('images.*')
<div class="alert alert-danger" role="alert">
   {{$message}}
   <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>   
@enderror

  <h1 class="md10">Manage Product</h1>
  <a href="{{URL::to('admin/product')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  @php
  if($id>0){
      $image_required="";
  }else{
      $image_required="required";
  }
  @endphp
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<div class="row m-t-30">
  <div class="col-md-12">

   <div class="row m-t-30">
    <div class="col-md-12">
       <form action="{{route('product.insert')}}" method="post" enctype="multipart/form-data">
          <div class="row">
             <div class="col-lg-12">
                <div class="card">
                   <div class="card-body">
                      @csrf
                      <div class="form-group">
                         <label for="name" class="control-label mb-1"> Name</label>
                         <input id="name" value="{{$name}}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                         @error('name')
                         <div class="alert alert-danger" role="alert">
                            {{$message}}		
                         </div>
                         @enderror
                      </div>
                      <div class="form-group">
                         <label for="slug" class="control-label mb-1"> Slug</label>
                         <input id="slug" value="{{$slug}}" name="slug" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                         @error('slug')
                         <div class="alert alert-danger" role="alert">
                            {{$message}}		
                         </div>
                         @enderror
                      </div>
                      <div class="form-group">
                         <label for="image" class="control-label mb-1"> Image</label>
                         <input id="image" name="image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}>
                         @if ($image!='')
                         <a href="{{asset('storage/media/'.$image)}}" target="_blank"><img width="100px" src="{{asset('storage/media/'.$image)}}" alt=""></a>
                        @endif 
                         @error('image')
                         <div class="alert alert-danger" role="alert">
                            {{$message}}		
                         </div>
                         @enderror
                      </div>
                      <div class="form-group">
                         <div class="row">
                            <div class="col-md-4">
                               <label for="category_id" class="control-label mb-1"> Category</label>
                               <select id="category_id" name="category_id" class="form-control" required>
                                  <option value="">Select Categories</option>
                                  @foreach($category as $list)
                                  @if($category_id==$list->id)
                                  <option selected value="{{$list->id}}">
                                     @else
                                  <option value="{{$list->id}}">
                                     @endif
                                     {{$list->category_name}}
                                  </option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="col-md-3">
                              <label for="brand" class="control-label mb-1"> Brand</label>
                              <select id="brand" name="brand" class="form-control">
                                 <option value="">Select Brand</option>
                                @foreach($brands as $list)
                               
                                     @if($brand==$list->id)
                                    <option value="{{$list->id}}" selected>{{$list->name}}</option>
                                    @else
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endif
                                 @endforeach
                              </select>
                           </div>
                            <div class="col-md-4">
                               <label for="model" class="control-label mb-1"> Model</label>
                               <input id="model" value="{{$model}}" name="model" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                            </div>
                         </div>
                      </div>
                      <div class="form-group">
                         <label for="short_desc" class="control-label mb-1"> Short Desc</label>
                         <textarea id="short_desc" name="short_desc" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$short_desc}}</textarea>
                      </div>
                      <div class="form-group">
                         <label for="desc" class="control-label mb-1"> Desc</label>
                         <textarea id="desc" name="desc" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$desc}}</textarea>
                      </div>
                      <div class="form-group">
                         <label for="keywords" class="control-label mb-1"> Keywords</label>
                         <textarea id="keywords" name="keywords" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$keywords}}</textarea>
                      </div>
                      <div class="form-group">
                         <label for="technical_specification" class="control-label mb-1"> Technical Specification</label>
                         <textarea id="technical_specification" name="technical_specification" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$technical_specification}}</textarea>
                      </div>
                      <div class="form-group">
                         <label for="uses" class="control-label mb-1"> Uses</label>
                         <textarea id="uses" name="uses" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$uses}}</textarea>
                      </div>
                      <div class="form-group">
                         <label for="warranty" class="control-label mb-1"> Warranty</label>
                         <textarea id="warranty" name="warranty" type="text" class="form-control" aria-required="true" aria-invalid="false" required>{{$warranty}}</textarea>
                      </div>
                      <div class="form-group">
                        <div class="row">
                           <div class="col-md-4">
                              <label for="lead_time" class="control-label mb-1">Lead Time</label>
                              <input id="lead_time" value="{{$lead_time}}" name="lead_time" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                           </div>
                           <div class="col-md-4">
                              <label for="tax_id" class="control-label mb-1">Tax</label>
                              <select id="tax_id" name="tax_id" class="form-control" required>
                                 <option value="">Select Tax</option>
                                 @foreach($taxs as $list)
                                 @if($tax_id==$list->id)
                                 <option selected value="{{$list->id}}">
                                    @else
                                 <option value="{{$list->id}}">
                                    @endif
                                    {{$list->tax_desc}}
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                           
                        </div>
                   </div>

                   <div class="form-group">
                     <div class="row">
                        <div class="col-md-3">
                           <label for="is_promo" class="control-label mb-1">Is Promo</label>
                              <select id="is_promo" name="is_promo" class="form-control" required>
                                 @if ($is_promo=='1')
                                 <option value="1" selected>Yes</option>
                                 <option value="0">No</option>
                                 @else
                                 <option value="1" >Yes</option>
                                 <option value="0" selected>No</option>
                                 @endif
                              </select>
                        </div>

                        <div class="col-md-3">
                           <label for="is_featured" class="control-label mb-1">Is Featured</label>
                              <select id="is_featured" name="is_featured" class="form-control" required>
                                 @if ($is_featured=='1')
                                 <option value="1" selected>Yes</option>
                                 <option value="0">No</option>
                                 @else
                                 <option value="1" >Yes</option>
                                 <option value="0" selected>No</option>
                                 @endif
                              </select>
                        </div>
                        
                        <div class="col-md-3">
                           <label for="is_discounted" class="control-label mb-1">Is Discounted</label>
                              <select id="is_discounted" name="is_discounted" class="form-control" required>
                                 @if ($is_discounted=='1')
                                 <option value="1" selected>Yes</option>
                                 <option value="0">No</option>
                                 @else
                                 <option value="1" >Yes</option>
                                 <option value="0" selected>No</option>
                                 @endif
                              </select>
                        </div>

                        <div class="col-md-3">
                           <label for="is_tranding" class="control-label mb-1">Is Tranding</label>
                              <select id="is_tranding" name="is_tranding" class="form-control" required>
                                 @if ($is_tranding=='1')
                                 <option value="1" selected>Yes</option>
                                 <option value="0">No</option>
                                 @else
                                 <option value="1" >Yes</option>
                                 <option value="0" selected>No</option>
                                 @endif
                              </select>
                        </div>
                      </div>
                  </div>
                  


                   </div>
                </div>
             </div>

          </div>
          <h2 class="mb10 ml15">Product Images</h2>
 
          <div class="col-lg-12">

             <div class="card">
                <div class="card-body">
                   <div class="form-group">
                      <div class="row" id="product_images_box">
                        @php
   
                        $loop_count_num=1;
               
                        @endphp 
               
                        @foreach($productImagesArr as $key=>$val)
                       
                        @php 
                         $loop_count_prev= $loop_count_num;
                         $pIArr=(array)$val;
               
                        @endphp 
               
                         <input id="piid" type="hidden" name="piid[]" value="{{$pIArr['id']}}">
                        <div class="col-md-4" class="product_images_{{$loop_count_num++}}'">
                           <label for="images" class="control-label mb-1"> Image</label>
                           <input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}>
                           @if ($pIArr['images']!='')
                           <a href="{{asset('storage/media/'.$pIArr['images'])}}" target="_blank"><img width="200px" src="{{asset('storage/media/'.$pIArr['images'])}}" alt=""></a>
                          @endif 
                        </div>
                        @if($loop_count_num==2)
                         <div class="col-md-2 pt-4">
                            <label for="images" class="control-label mb-1"></label>
                           
                              <button type="button" class="btn btn-success btn-lg" onclick="add_image_more()">
                              <i class="fa fa-plus"></i>&nbsp; Add</button>  
                                         
                         </div>
                         @else  
                         <div class="col-md-2 pt-4">
                         <a href="{{url('admin/product/image_delete/')}}/{{$pIArr['id']}}/{{$id}}"><button type="button"  class="btn btn-danger btn-lg">
                           <i class="fa fa-minus"></i>&nbsp; Remove</button></a>
                        </div>
   
                         @endif 

                         
                         @endforeach 
                      </div>
                  
                   </div>
                </div>                 
           </div>
      
       </div>
         
       <h2 class="mb10 ml15">Product Attributes</h2>
 
       <div class="col-lg-12" id="product_attr_box">
         @php 
         $loop_count_num=1;
         @endphp
         @foreach($productAttrArr as $key=>$val)
         @php 
         $loop_count_prev=$loop_count_num;
         $pAArr=(array)$val;
         @endphp

         <input id="paid" type="hidden" name="paid[]" value="{{$pAArr['id']}}">
            <div class="card" id="product_attr_{{$loop_count_num++}}">
             <div class="card-body">
                <div class="form-group">
                   <div class="row">
                      <div class="col-md-2">
                         <label for="sku" class="control-label mb-1"> SKU</label>
                         <input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['sku']}}" required>
                      </div>
                      <div class="col-md-2">
                         <label for="mrp" class="control-label mb-1"> MRP</label>
                         <input id="mrp" name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['mrp']}}" required>
                      </div>
                      <div class="col-md-2">
                         <label for="price" class="control-label mb-1"> Price</label>
                         <input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['price']}}" required>
                      </div>
                      <div class="col-md-3">
                         <label for="size_id" class="control-label mb-1"> Size</label>
                         <select id="size_id" name="size_id[]" class="form-control">
                            <option value="">Select Size</option>
                            @foreach($sizes as $list)
                               @if($pAArr['size_id']==$list->id)
                               <option value="{{$list->id}}" selected>{{$list->size}}</option>
                               @else
                                <option value="{{$list->id}}">{{$list->size}}</option>
                              @endif
                            @endforeach
                         </select>
                      </div>
                      <div class="col-md-3">
                         <label for="color_id" class="control-label mb-1"> Color</label>
                         <select id="color_id" name="color_id[]" class="form-control">
                            <option value="">Select Color</option>
                           @foreach($colors as $list)
                          
                                @if($pAArr['color_id']==$list->id)
                               <option value="{{$list->id}}" selected>{{$list->color}}</option>
                               @else
                               <option value="{{$list->id}}">{{$list->color}}</option>
                               @endif
                            @endforeach
                         </select>
                      </div>
            
                      <div class="col-md-2">
                         <label for="qty" class="control-label mb-1"> Qty</label>
                         <input id="qty" name="qty[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="{{$pAArr['qty']}}" required>
                      </div>
                      <div class="col-md-4">
                         <label for="attr_image" class="control-label mb-1"> Image</label>
                         <input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_required}}>
                         @if ($pAArr['attr_image']!='')
                         <a href="{{asset('storage/media/'.$pAArr['attr_image'])}}" target="_blank"><img width="100px" src="{{asset('storage/media/'.$pAArr['attr_image'])}}" alt=""></a>
                        @endif 
                      </div>
                      @if($loop_count_num==2)
                      <div class="col-md-2 pt-4">
                         <label for="attr_image" class="control-label mb-1"></label>
                           <button type="button" class="btn btn-success btn-lg" onclick="add_more()">
                           <i class="fa fa-plus"></i>&nbsp; Add</button>                 
                      </div>
                      @else
                      <div class="col-md-2 pt-4">
                      <a href="{{url('admin/product/delete_attr/')}}/{{$pAArr['id']}}/{{$id}}"><button type="button"  class="btn btn-danger btn-lg">
                        <i class="fa fa-minus"></i>&nbsp; Remove</button></a>
                     </div>

                      @endif  
                   </div>
                </div>
             </div>                 
        </div>
        @endforeach 
    </div>
          
                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                        Submit
                        </button>
                    </div>
                    <input type="hidden" name="id" value="{{$id}}"/>
          </form>

    </div>
    
</div>     
      

<script>
   var loop_count=1;
    function add_more(){
       loop_count++;
        var html = '<input id="paid" type="hidden" name="paid[]"><div class="card" id="product_attr_'+loop_count+'"><div class="card-body"><div class="form-group"><div class="row">';

            html+='<div class="col-md-2"><label for="sku" class="control-label mb-1">SKU</label><input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="" required></div>';

            html+='<div class="col-md-2"><label for="mrp" class="control-label mb-1">MRP</label><input id="mrp" name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="" required></div>';
            
            html+='<div class="col-md-2"><label for="price" class="control-label mb-1">Price</label><input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="" required></div>';

            var size_id_html =jQuery('#size_id').html();
            size_id_html = size_id_html.replace("selected","")
            html+='<div class="col-md-3"><label for="size_id" class="control-label mb-1">Size</label><select id="size_id" name="size_id[]" class="form-control">'+size_id_html+'</select></div>';
            var color_id_html =jQuery('#color_id').html();
            color_id_html = color_id_html.replace("selected","")
            html+='<div class="col-md-3"><label for="color_id" class="control-label mb-1">Color</label><select id="color_id" name="color_id[]" class="form-control" >'+color_id_html+'</select></div>';

            html+='<div class="col-md-2"><label for="qty" class="control-label mb-1"> Qty</label><input id="qty" name="qty[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="" required></div>';

            html+='<div class="col-md-4"><label for="attr_image" class="control-label mb-1"> Image</label><input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required></div>';
            
            html+='<div class="col-md-2 pt-4"><label for="attr_image" class="control-label mb-1"></label><button type="button" class="btn btn-danger btn-lg" onclick=remove_more("'+loop_count+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></a></div>';
           
           html+= '</div></div></div></div>';


            jQuery('#product_attr_box').append(html)
    }   

    function remove_more(loop_count){
      jQuery('#product_attr_'+loop_count).remove();
    }

    var loop_image_count=1;

    function add_image_more(){

            loop_image_count++;

           var html =' <input id="piid" type="hidden" name="piid[]" value=""><div class="col-md-4 product_images_'+loop_image_count+'"><label for="images" class="control-label mb-1"> Image</label><input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required></div>';
       
            html+='<div class="col-md-2 pt-4 product_images_'+loop_image_count+'"><label for="images" class="control-label mb-1"></label><button type="button" class="btn btn-danger btn-lg" onclick=remove_images_more("'+loop_image_count+'")><i class="fa fa-minus"></i>&nbsp; Remove</button></a></div>';

            jQuery('#product_images_box').append(html)
            // product_images_'+loop_image_count+'"

    }
    function remove_images_more(loop_image_count){
      jQuery('.product_images_'+loop_image_count).remove();
    }
    
    CKEDITOR.replace('short_desc');
    CKEDITOR.replace('desc');
    CKEDITOR.replace('technical_specification');
  
</script>


@endsection

      
   
                      {{-- <div class="form-group">
                           <div class="row">
                              <div class="col-md-4">
                                 <label for="lead_time" class="control-label mb-1">Lead Time</label>
                                 <input id="lead_time" value="{{$lead_time}}" name="lead_time" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                              </div>
                              <div class="col-md-4">
                                 <label for="tax" class="control-label mb-1">Tax</label>
                               <input id="tax" value="{{$tax}}" name="tax" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                              </div>
                              <div class="col-md-4">
                                 <label for="tax_type" class="control-label mb-1">Tax Type</label>
                               <input id="tax_type" value="{{$tax_type}}" name="tax_type" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                              </div>
                           </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                           <div class="col-md-3">
                              <label for="is_promo" class="control-label mb-1">Is Promo</label>
                              <select id="is_promo" name="is_promo" class="form-control" required>
                                 <option value="1">Yes</option>
                                 <option value="0">No</option>
                              </select>
                           <div class="col-md-3">
                              
                           </div>
                           <div class="col-md-3">
                              
                           </div>
                        </div> --}}