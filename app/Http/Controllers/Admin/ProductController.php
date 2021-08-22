<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Product::all(); 
        return view('admin.product',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_product(Request $request,$id='')
    {
      
        
        if($id>0){
            $arr=Product::where(['id'=>$id])->get();
            
            $result['category_id']=$arr['0']->category_id;
            $result['name']=$arr['0']->name;
            $result['image']=$arr['0']->image;
            $result['slug']=$arr['0']->slug;
            $result['brand']=$arr['0']->brand;
            $result['model']=$arr['0']->model;
            $result['short_desc']=$arr['0']->short_desc;
            $result['desc']=$arr['0']->desc;
            $result['keywords']=$arr['0']->keywords;
            $result['technical_specification']=$arr['0']->technical_specification;
            $result['uses']=$arr['0']->uses;
            $result['warranty']=$arr['0']->warranty;

            $result['lead_time']=$arr['0']->lead_time;
            $result['tax_id']=$arr['0']->tax_id;
            $result['tax_type']=$arr['0']->tax_type;
            $result['is_promo']=$arr['0']->is_promo;
            $result['is_featured']=$arr['0']->is_featured;
            $result['is_discounted']=$arr['0']->is_discounted;
            $result['is_tranding']=$arr['0']->is_tranding;

            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;

            $result['productAttrArr']=DB::table('products_attr')->where(['products_id'=>$id])->get();
           
            $productImagesArr=DB::table('product_images')->where(['products_id'=>$id])->get();
            // print_r($productImagesArr[0]);
            // die();
            if(!isset($productImagesArr[0])){
                $result['productImagesArr']['0']['id']='';
                $result['productImagesArr']['0']['images']='';
            }else{
                $result['productImagesArr']=$productImagesArr;
            }
        }else{
           
            $result['category_id']='';
            $result['name']='';
            $result['image']='';
            $result['slug']='';
            $result['brand']='';
            $result['model']='';
            $result['short_desc']='';
            $result['desc']='';
            $result['keywords']='';
            $result['technical_specification']='';
            $result['uses']='';
            $result['warranty']='';

            $result['lead_time']='';
            $result['tax_id']='';
            $result['is_promo']='';
            $result['is_featured']='';
            $result['is_discounted']='';
            $result['is_tranding']='';

            $result['status']='';
            $result['id']=0;

            $result['productAttrArr'][0]['id']='';
            $result['productAttrArr'][0]['products_id']='';
            $result['productAttrArr'][0]['sku']='';
            $result['productAttrArr'][0]['attr_image']='';
            $result['productAttrArr'][0]['mrp']='';
            $result['productAttrArr'][0]['price']='';
            $result['productAttrArr'][0]['qty']='';
            $result['productAttrArr'][0]['size_id']='';
            $result['productAttrArr'][0]['color_id']='';
           
            $result['productImagesArr']['0']['id']='';
            $result['productImagesArr']['0']['images']='';
            
    
        }


        $result['category']=DB::table('categories')->where(['status'=>1])->get();

        $result['sizes']=DB::table('sizes')->where(['status'=>1])->get();

        $result['colors']=DB::table('colors')->where(['status'=>1])->get();

        $result['brands']=DB::table('brands')->where(['status'=>1])->get();

        $result['taxs']=DB::table('taxs')->where(['status'=>1])->get();
     
        return view('admin.manage_product',$result);
    }

    public function manage_product_insert(Request $request){
       
        if($request->post('id')>0){
            $image_validation="mimes:jpeg,jpg,png";
            
        }else{
            $image_validation="required|mimes:jpeg,jpg,png";
        }
            $request->validate([
                'name'=>'required',
                'image.*'=>$image_validation,
                'slug'=>'required|unique:products,slug,'.$request->post('id'),
                'attr_image.*' =>$image_validation,
                'images.*' =>$image_validation
            ]);
            $paidArr=$request->post('paid');
            $skuArr=$request->post('sku');
            $mrpArr=$request->post('mrp');
            $priceArr=$request->post('price');
            $qtyArr=$request->post('qty');
            $size_idArr=$request->post('size_id');
            $color_idArr=$request->post('color_id');
         
            foreach($skuArr as $key=>$val){
            //    dd($paidArr[$key]);
                $check=DB::table('products_attr')->
                where('sku','=',$skuArr[$key])->
                where('id','!=',$paidArr[$key])->
                get();
                // dd($check);
                if(isset($check[0])){
                    $request->session()->flash('sku_error',$skuArr[$key].' SKU นี้ใช้งานแล้ว');
                    return redirect(request()->headers->get('referer'));
                }
            }


            if($request->post('id')>0){
                $model = Product::find($request->post('id'));
                $mgs="อัพเดทสินค้าเรียบร้อยแล้ว";
            }else{
                $model = new Product();
                $mgs="เพิ่มข้อมูลสินค้าสำเร็จแล้ว";
                $model->status=1;
            }

            if($request->hasFile('image')){
                if($request->post('id')>0){
                    $arrImage=DB::table('products')->where(['id'=>$request->post('id')])->get();
                if( Storage::exists('/public/media/'.$arrImage[0]->image)){
                    Storage::delete('/public/media/'.$arrImage[0]->image);
                }
            }
                $image = $request->file('image');
                $ext=$image->extension();
                $image_name=time().'.'.$ext;
                $image->storeAs('/public/media',$image_name);
                $model->image=$image_name;
            }
            $model->category_id=$request->post('category_id');
            $model->name=$request->post('name');
            // $model->image=$request->post('image');
            $model->slug=$request->post('slug');
            $model->brand=$request->post('brand');
            $model->model=$request->post('model');
            $model->short_desc=$request->post('short_desc');
            $model->desc=$request->post('desc');
            $model->keywords=$request->post('keywords');
            $model->technical_specification=$request->post('technical_specification');
            $model->uses=$request->post('uses');
            $model->warranty=$request->post('warranty');

            $model->lead_time=$request->post('lead_time');
            $model->tax_id=$request->post('tax_id');
            $model->is_promo=$request->post('is_promo');
            $model->is_featured=$request->post('is_featured');
            $model->is_discounted=$request->post('is_discounted');
            $model->is_tranding=$request->post('is_tranding');
            // $model->status=1;
       
            $model->save();
            $pid=$model->id;

            /* loop product attr */
            
            foreach($skuArr as $key=>$val){
                $productAttrArr=[];
                $productAttrArr['products_id']=$pid;
                $productAttrArr['sku']=$skuArr[$key];
             
                $productAttrArr['mrp']=(int)$mrpArr[$key];
                $productAttrArr['price']=(int)$priceArr[$key];
                $productAttrArr['qty']=(int)$qtyArr[$key];
                if($size_idArr[$key]==''){
                    $productAttrArr['size_id']=0;
                }else{
                    $productAttrArr['size_id']=$size_idArr[$key];
                }
                if($color_idArr[$key]==''){
                    $productAttrArr['color_id']=0;
                }else{
                    $productAttrArr['color_id']=$color_idArr[$key];
                }
             
                if($request->hasFile("attr_image.$key")){
                
                    if($paidArr[$key]!=''){
                        // echo '<pre>';
                        // print_r($paidArr[$key]);
                        // die();
                        $arrImage=DB::table('products_attr')->where(['id'=>$paidArr[$key]])->get();
                    if( Storage::exists('/public/media/'.$arrImage[0]->attr_image)){
                        Storage::delete('/public/media/'.$arrImage[0]->attr_image);
                    }
                }

                    $rand=rand('1111111111','9999999999');
                    $attr_image=$request->file("attr_image.$key");
                    $ext=$attr_image->extension();
                    $image_name=$rand.'.'.$ext;
                    $request->file("attr_image.$key")->storeAs('/public/media',$image_name);
                    $productAttrArr['attr_image']= $image_name;

                    if($paidArr[$key]!=''){
                        DB::table('products_attr')->where(['id'=>$paidArr[$key]])->update($productAttrArr);
                    }else{
                        DB::table('products_attr')->insert($productAttrArr);
                    }
                }

            
               
            }
        

            //product image
            $piidArr=$request->post('piid');

            foreach($piidArr as $key=>$val){
             
                $productImagesArr['products_id']=$pid;
                if($request->hasFile("images.$key")){
                 
                    if($piidArr[$key]!=''){
                       
                        $arrImage=DB::table('product_images')->where(['id'=>$piidArr[$key]])->get();
                        // echo '<pre>';
                        // print_r($arrImage);
                        // die();
                    if( Storage::exists('/public/media/'.$arrImage[0]->images)){
                        Storage::delete('/public/media/'.$arrImage[0]->images);
                    }
                }
           
                    $rand=rand('1111111111','9999999999');
                    $attr_image=$request->file("images.$key");
                    $ext=$attr_image->extension();
                    $image_name=$rand.'.'.$ext;
                    $request->file("images.$key")->storeAs('/public/media',$image_name);
                    $productImagesArr['images']= $image_name;
                }
                   // echo '<pre>';
                        // print_r($arrImage);
                        // die();
                if($piidArr[$key]!=''){
                     
                    DB::table('product_images')->where(['id'=>$piidArr[$key]])->update($productImagesArr);
                }else{
                    DB::table('product_images')->insert($productImagesArr);
                }
            }

            $request->session()->flash('message', $mgs);

            return redirect('admin/product');
    }
   
    public function delete(Request $request,$id){
        $model = Product::find($id);
        
        $model->delete();
        $request->session()->flash('messagedelete','ลบรายการเรียบร้อยแล้ว');
        return redirect('admin/product');
     }


     public function status(Request $request,$status,$id){
         
        $test = Product::find($id);        
        $test->status=$status;  
        if($test->status==1){
           
            $mgs='เปิดรายการที่ '.$test->id.' เรียบร้อยแล้ว';
            $type ='message';
        }else if($test->status==0){
            $mgs='ปิดรายการที่ '.$test->id.' เรียบร้อยแล้ว';
            $type ='messagedelete';
          
        }
        $test->save();
        $request->session()->flash($type, $mgs);
         
        return redirect('admin/product');
     }

     public function delete_attrr(Request $request,$paid,$pid){
        $arrImage=DB::table('products_attr')->where(['id'=>$paid])->get();
     
        if( Storage::exists('/public/media/'.$arrImage[0]->attr_image)){
            Storage::delete('/public/media/'.$arrImage[0]->attr_image);
        }
        DB::table('products_attr')->where(['id'=>$paid])->delete();
 
        $request->session()->flash('messagedelete','ลบรายการเรียบร้อยแล้ว');
        return redirect('admin/product/'.$pid.'/edit');
     }


     public function image_delete(Request $request,$piid,$pid){
         $arrImage=DB::table('product_images')->where(['id'=>$piid])->get();
        if( Storage::exists('/public/media/'.$arrImage[0]->images)){
            Storage::delete('/public/media/'.$arrImage[0]->images);
        }
        // Storage::delete('/public/media/'.$arrImage[0]->images);
        DB::table('product_images')->where(['id'=>$piid])->delete();
 
        $request->session()->flash('messagedelete','ลบรายการเรียบร้อยแล้ว');
        return redirect('admin/product/'.$pid.'/edit');
     }
}
