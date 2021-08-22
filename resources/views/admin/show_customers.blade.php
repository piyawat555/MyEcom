@extends('admin.layout')
@section('page_title','Show Customers Details')
@section('customers_select','active')
@section('container')

  <h1 class="mb10">Customers Details</h1>
  <a href="{{URL::to('admin/customers')}}">
    <button type="button" class="btn btn-success">Back</button>
  </a>
  <div class="row m-t-30">
    <div class="col-md-8">
        <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <tbody>

                    <tr>
                        <td><strong>Name</strong></td>
                        <td>{{$name}}</td>
                    </tr>

                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{$email}}</td>
                    </tr>

                    <tr>
                        <td><strong>Mobile</strong></td>
                        <td>{{$mobile}}</td>
                    </tr>

                    <tr>
                        <td><strong>Address</strong></td>
                        <td>{{$address}}</td>
                    </tr>

                    <tr>
                        <td><strong>City</strong></td>
                        <td>{{$city}}</td>
                    </tr>

                    <tr>
                        <td><strong>State</strong></td>
                        <td>{{$state}}</td>
                    </tr>

                    <tr>
                        <td><strong>Zip</strong></td>
                        <td>{{$zip}}</td>
                    </tr>

                    <tr>
                        <td><strong>Company</strong></td>
                        <td>{{$company}}</td>
                    </tr>

                    <tr>
                        <td><strong>Added On</strong></td>
                        <td>{{\Carbon\Carbon::parse($created_at)->format('d-m-y h:i:s')}}</td>
                    </tr>

                    <tr>
                        <td><strong>Updated On</strong></td>
                        <td>{{\Carbon\Carbon::parse($updated_at)->format('d-m-y h:i:s')}}</td>
                    </tr>
                    
                    <tr>
                        <td><strong>GST Number</strong></td>
                        <td>{{$gstin}}</td>
                    </tr>

                    <tr>
                        <td><strong>Status</strong></td>
                        <td>{{$status}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>



@endsection