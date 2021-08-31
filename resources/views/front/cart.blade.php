@extends('front.layout')
@section('page_title','Cart Page')
@section('container')
<section id="aa-catg-head-banner">
   <!-- <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img"> -->
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Cart Page</h2>
        <ol class="breadcrumb">
          <li><a href="index.html">Home</a></li>                   
          <li class="active">Cart</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->

 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             @php
              $totalprice=0;
             @endphp
             <form action="">
              
            @if(isset($listcarts[0]))
            <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($listcarts as $list)
                  

                      <tr id="cart_box{{$list->attr_id}}">
                        <td><a class="remove" href="javascript:void(0)" onclick="DeleteProductCart('{{$list->pid}}','{{$list->size}}','{{$list->color}}','{{$list->attr_id}}')" ><fa class="fa fa-close"></fa></a></td>
                        <td><a href="{{url('product/'.$list->slug)}}"><img src="{{asset('storage/media/'.$list->image)}}" alt="img"></a></td>
                        <td><a class="aa-cart-title" href="{{url('product/'.$list->slug)}}">{{$list->name}}</a>
                        @if($list->size!='')
                         <br>SIZE : {{$list->size}}
                        @endif
                        @if($list->color!='')
                        <br>COLOR : {{$list->color}} 
                        @endif
                      </td>
                   
                        <td>RS {{$list->price}} / EA</td>
                        <td><input id="qty{{$list->attr_id}}" class="aa-cart-quantity" type="number" value="{{$list->qty}}" onchange="updateQty('{{$list->pid}}','{{$list->size}}','{{$list->color}}','{{$list->attr_id}}','{{$list->price}}')"></td>
                        <td id="total_price_{{$list->attr_id}}">Rs : {{$list->qty*$list->price}}</td>
                        @php
                        $totalprice=$totalprice+($list->qty*$list->price)
                        @endphp
                      </tr>
                      @endforeach
                      
                      <tr>
                        <td colspan="6" class="aa-cart-view-bottom">
                          
                          <input class="aa-cart-view-btn" type="button" value="Checkout">
                        </td>
                      </tr>
                      </tbody>
                  </table>
                </div>
            @else
                  <h1>ยังไม่เพิ่มข้อมูลสินค้า</h1>
            @endif
              
              
             </form>
             <!-- Cart Total view -->
             <div class="cart-view-total">
               <h4>Cart Totals</h4>
               <table class="aa-totals-table">
                 <tbody>
                   <tr>
                     <th>Subtotal</th>
                     <td>$450</td>
                   </tr>
                   <tr>
                     <th>Total</th>
                     <td id="totalprice">{{$totalprice}}</td>
                   </tr>
                 </tbody>
               </table>
               <a href="#" class="aa-cart-view-btn">Proced to Checkout</a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <input type="hidden" id="qty" name="qty" value="1">
  <form id="FrmAddToCart">
  @csrf
<input type="hidden"  id="size_id" name="size_id"/>
<input type="hidden"  id="color_id" name="color_id"/>
<input type="hidden"  id="pqty" name="pqty"/>
<input type="hidden"  id="product_id" name="product_id"/>
</form>
@endsection


