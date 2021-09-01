<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class FrontController extends Controller
{
    
    public function index(Request $request)
    {
        // getData();
        // die();
      
        $result['home_categories']=DB::table('categories')
                ->where(['status'=>1])
                ->where(['is_home'=>1])
                ->get();
               
      
               
        foreach($result['home_categories'] as $list){
            
            $result['home_categories_product'][$list->id]=
                DB::table('products')
                ->where(['status'=>1])
                ->where(['category_id'=>$list->id])
                ->get();
         
                foreach($result['home_categories_product'][$list->id] as $list1){
                
                 
                    $result['home_product_attr'][$list1->id]=
                        DB::table('products_attr')
                        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                        ->leftJoin('colors','colors.id','=','products_attr.color_id')
                        ->where(['products_attr.products_id'=>$list1->id])
                        ->get();
                    
                }
           
               
             
        }

        $result['home_brands']=DB::table('brands')
        ->where(['status'=>1])
        ->where(['is_home'=>1])
        ->get();
        
        
        $result['home_featured_product'][$list->id]=
                DB::table('products')
                ->where(['status'=>1])
                ->where(['is_featured'=>1])
                ->get();
         
              
                foreach($result['home_featured_product'][$list->id] as $list1){
                
                 
                    $result['home_featured_product_attr'][$list1->id]=
                        DB::table('products_attr')
                        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                        ->leftJoin('colors','colors.id','=','products_attr.color_id')
                        ->where(['products_attr.products_id'=>$list1->id])
                        ->get();
                    
                }
        

                $result['home_tranding_product'][$list->id]=
                DB::table('products')
                ->where(['status'=>1])
                ->where(['is_tranding'=>1])
                ->get();
         
                foreach($result['home_tranding_product'][$list->id] as $list1){
                
                 
                    $result['home_tranding_product_attr'][$list1->id]=
                        DB::table('products_attr')
                        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                        ->leftJoin('colors','colors.id','=','products_attr.color_id')
                        ->where(['products_attr.products_id'=>$list1->id])
                        ->get();
                    
                }


                $result['home_discounted_product'][$list->id]=
                DB::table('products')
                ->where(['status'=>1])
                ->where(['is_discounted'=>1])
                ->get();
         
                foreach($result['home_discounted_product'][$list->id] as $list1){
                
                 
                    $result['home_discounted_product_attr'][$list1->id]=
                        DB::table('products_attr')
                        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                        ->leftJoin('colors','colors.id','=','products_attr.color_id')
                        ->where(['products_attr.products_id'=>$list1->id])
                        ->get();
                    
                }
        
        
                $result['home_banner']=DB::table('home_banners')
                ->where(['status'=>1])
                ->get();
           
        return view('front.index',$result);
    }

    public function category(Request $request,$slug)
    {   
        $sort="";
        $sort_txt="";
        $filter_price_start="";
        $filter_price_end="";
        $color_filter="";
        $colorfilterArr=[];
        if($request->get('sort')!==null){
            $sort=$request->get('sort');
        }    
        
        $query=DB::table('products');
        $query=$query->leftJoin('categories','categories.id','=','products.category_id');
        $query=$query->leftJoin('products_attr','products.id','=','products_attr.products_id');
        $query=$query->where(['products.status'=>1]);
        $query=$query->where(['categories.category_slug'=>$slug]);
        if($sort=='name'){
            $query=$query->orderBy('products.name','asc');
            $sort_txt="Product Name";
        }
        if($sort=='date'){
            $query=$query->orderBy('products.id','desc');
            $sort_txt="Date";
        }
        if($sort=='price_desc'){
            $query=$query->orderBy('products_attr.price','desc');
            $sort_txt="Price - DESC";
        }if($sort=='price_asc'){
            $query=$query->orderBy('products_attr.price','asc');
            $sort_txt="Price - ASC";
        }
       
        if($request->get('filter_price_start')!==null && $request->get('filter_price_end')!==null){
           
            $filter_price_start=$request->get('filter_price_start');
            $filter_price_end=$request->get('filter_price_end');
            if($filter_price_start>0 && $filter_price_end>0){
                
                $query=$query->whereBetween('products_attr.price',array($filter_price_start,$filter_price_end));
                
            }
        }
       
        if($request->get('color_filter')!==null){
            $color_filter=$request->get('color_filter');
            $colorfilterArr = explode(":",$color_filter);
            $colorfilterArr = array_filter($colorfilterArr);
            $query=$query->where(['products_attr.color_id'=>$request->get('color_filter')]);    
        }

        $query=$query->distinct()->select('products.*');
        $query=$query->get();
        
        $result['product']=$query;
       
        foreach($result['product'] as $list1){
           
            $query1=DB::table('products_attr');
            $query1=$query1->leftJoin('sizes','sizes.id','=','products_attr.size_id');
            $query1=$query1->leftJoin('colors','colors.id','=','products_attr.color_id');
            $query1=$query1->where(['products_attr.products_id'=>$list1->id]);
            
            $query1=$query1->get();
           
            $result['product_attr'][$list1->id]=$query1;    

        }

        $result['color']=DB::table('colors')
                ->where(['status'=>1])
                ->get();
 

        $result['sort']=$sort;
        $result['sort_txt']=$sort_txt;
        $result['filter_price_start']=$filter_price_start;
        $result['filter_price_end']=$filter_price_end;
        $result['color_filter']=$color_filter;
        $result['colorfilterArr']=$colorfilterArr;
        return view('front.category',$result);
    }

    public function product(Request $request , $slug){
        $result['product']=
        DB::table('products')
        ->where(['status'=>1])
        ->where(['slug'=>$slug])
        ->get();
 
        foreach($result['product'] as $list1){
        
         
            $result['product_attr'][$list1->id]=
                DB::table('products_attr')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->leftJoin('colors','colors.id','=','products_attr.color_id')
                ->where(['products_attr.products_id'=>$list1->id])
                ->get();
            
        }

        foreach($result['product'] as $list1){
        
         
            $result['product_images'][$list1->id]=
                DB::table('product_images')
                ->where(['product_images.products_id'=>$list1->id])
                ->get();
            
        }

        $result['related_product']=
        DB::table('products')
        ->where(['status'=>1])
        ->where('slug','!=',$slug)
        ->where(['category_id'=>$result['product'][0]->category_id])
        ->get();
        

        foreach($result['related_product'] as $list1){
        
         
            $result['related_product_attr'][$list1->id]=
                DB::table('products_attr')
                ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
                ->leftJoin('colors','colors.id','=','products_attr.color_id')
                ->where(['products_attr.products_id'=>$list1->id])
                ->get();
            
        }
        // prx($result);
        return view('front.product',$result);
    }
 
   
    public function add_to_cart(Request $request){
      
        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        }else{
            $uid = getUserTempId(); 
            $user_type = "Not-Reg";            
        }
       $size_id = $request->post('size_id');
       $color_id = $request->post('color_id');
       $pqty = $request->post('pqty');
       $product_id = $request->post('product_id');
        
       $result=DB::table('products_attr')
        ->select('products_attr.id')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_id'=>$product_id])
        ->where(['sizes.size'=>$size_id])
        ->where(['colors.color'=>$color_id])
        ->get();

        

        $product_attr_id = $result[0]->id;

        $check=DB::table('carts')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->where(['product_id'=>$product_id])
        ->where(['product_attr_id'=>$product_attr_id])
        ->get();

        if(isset($check[0])){
        $update_id = $check[0]->id;
        if($pqty==0){
            DB::table('carts')
            ->where(['id'=>$update_id])
            ->delete();
            $msg= "ลบออร์เดอร์ออกแล้ว";
        }else{
            DB::table('carts')
            ->where(['id'=>$update_id])
            ->update(['qty'=>$pqty]);
            $msg= "อัพเดท เข้า ออร์เดอร์แล้ว";
        }
           
        }else{
            $id=DB::table('carts')->insertGetId([
            'user_id'=>$uid,
            'user_type'=>$user_type,
            'qty'=>$pqty,
            'product_id'=>$product_id,
            'product_attr_id'=>$product_attr_id,
            'added_on'=> date('Y-m-d h:i:s')
            ]);
            
            $msg = "เพิ่มข้อมูลสินค้าเข้าออร์เดอร์แล้ว";
        }

        $result=DB::table('carts')
        ->leftJoin('products','products.id','=','carts.product_id')
        ->leftJoin('products_attr','products_attr.id','=','carts.product_attr_id')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->select('carts.qty','products.name','products.image','sizes.size','colors.color','products_attr.price','products.slug','products.id as pid','products_attr.id as attr_id')
        ->get();

        return response()->json(['msg'=>$msg,'data'=>$result,'totalItem'=>count($result)]);
    }

    
    public function cart(Request $request){

        if($request->session()->has('FRONT_USER_LOGIN')){
            $uid = $request->session()->get('FRONT_USER_LOGIN');
            $user_type = "Reg";
        }else{
            $uid = getUserTempId(); 
            $user_type = "Not-Reg";            
        }

        $result['listcarts']=DB::table('carts')
        ->leftJoin('products','products.id','=','carts.product_id')
        ->leftJoin('products_attr','products_attr.id','=','carts.product_attr_id')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['user_id'=>$uid])
        ->where(['user_type'=>$user_type])
        ->select('carts.qty','products.name','products.image','sizes.size','colors.color','products_attr.price','products_attr.attr_image','products.slug','products.id as pid','products_attr.id as attr_id')
        ->get();

        
        return view('front.cart',$result);
    }
}
