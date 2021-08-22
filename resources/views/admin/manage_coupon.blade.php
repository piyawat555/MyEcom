@extends('admin.layout')

@section('container')
@section('page_title','Manage CateGory')
@section('coupon_select','active')
  <h1 class="md10">Manage Coupon</h1>
  <a href="{{URL::to('admin/coupon')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  
  <div class="row m-t-30">
    <div class="col-md-12">
            
                <div class="col-lg-12">
                    {{session('message')}}
                    <div class="card">                    
                        <div class="card-body">
                            
                            <form action="{{route('coupon.insert')}}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <div class="row">
                                       <div class="col-md-6">
                                        <label for="title" class="control-label mb-1">Title</label>
                                        <input id="title" name="title" type="text" value="{{$title}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('title')
                                        <div class="alert alert-danger" role="alert">
                                            {{$message}}
                                        </div>    
                                        @enderror
                                       </div> 

                                       <div class="col-md-6">
                                        <label for="code" class="control-label mb-1">Code</label>
                                        <input id="code" name="code" type="text" value="{{$code}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('code')
                                        <div class="alert alert-danger" role="alert">
                                            {{$message}}
                                        </div>
                                         @enderror
                                       </div> 

                                       <div class="col-md-6">
                                        <label for="value" class="control-label mb-1">Value</label>
                                        <input id="value" name="value" type="text" value="{{$value}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('value')
                                        <div class="alert alert-danger" role="alert">
                                            {{$message}}
                                        </div>
                                         @enderror
                                       </div> 

                                       <div class="col-md-6">
                                        <label for="type" class="control-label mb-1">Type</label>
                                        <select id="type" name="type" class="form-control" required>
                                            @if ($type=='Value')
                                            <option value="Value" selected>Value</option>
                                            <option value="Per">Per</option>
                                            @elseif ($type=='Per')
                                            <option value="Value" >Value</option>
                                            <option value="Per" selected>Per</option>
                                            @else
                                            <option value="Value">Value</option>
                                            <option value="Per">Per</option>
                                            @endif
                                         </select>
                                       </div> 

                                    </div> 
                                </div> 
                                      
                                <div class="form-group">
                                    <div class="row">
                                       <div class="col-md-6">
                                        <label for="min_order_amt" class="control-label mb-1">Min Order Amt</label>
                                        <input id="min_order_amt" name="min_order_amt" type="text" value="{{$min_order_amt}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                        @error('min_order_amt')
                                        <div class="alert alert-danger" role="alert">
                                            {{$message}}
                                        </div>    
                                        @enderror
                                       </div> 

                                       <div class="col-md-6">
                                        <label for="is_one_time" class="control-label mb-1">Is One Time</label>
                                        <select id="is_one_time" name="is_one_time" class="form-control" required>
                                            @if ($is_one_time=='1')
                                            <option value="1" selected>Yes</option>
                                            <option value="0">No</option>
                                            @else
                                            <option value="1">Yes</option>
                                            <option value="0" selected>No</option>
                                            @endif
                                         </select>
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