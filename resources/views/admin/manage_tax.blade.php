@extends('admin.layout')

@section('container')
@section('page_title','Manage Tax')
@section('tax_select','active')
  <h1 class="md10">Manage Tax</h1>
  <a href="{{URL::to('admin/tax')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  
  <div class="row m-t-30">
    <div class="col-md-12">
            
                <div class="col-lg-12">
                    {{session('message')}}
                    <div class="card">                    
                        <div class="card-body">
                            
                            <form action="{{route('tax.insert')}}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="tax_desc" class="control-label mb-1">Tax</label>
                                    <input id="tax_desc" name="tax_desc" type="tax_desc" value="{{$tax_desc}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('tax_desc')
                                    <div class="alert alert-danger" role="alert">
                                        {{$message}}
                                    </div>
                                     
                                    @enderror
                                </div>
                           
                                <div class="form-group">
                                    <label for="tax_value" class="control-label mb-1">tax_value</label>
                                    <input id="tax_value" name="tax_value" type="tax_desc" value="{{$tax_value}}" class="form-control" aria-required="true" aria-invalid="false" required>
                                    @error('tax_value')
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