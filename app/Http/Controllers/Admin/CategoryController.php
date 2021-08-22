<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Category;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Category::all(); 
        return view('admin.category',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_category(Request $request,$id='')
    {
        
        if($id>0){
            $arr=Category::where(['id'=>$id])->get();
            
            $result['category_name']=$arr['0']->category_name;
            $result['category_slug']=$arr['0']->category_slug;
            $result['parent_category_id']=$arr['0']->parent_category_id;
            $result['category_image']=$arr['0']->category_image;
            // $result['status']=$arr['0']->status;
            $result['is_home']=$arr['0']->is_home;
            $result['is_home_selected']="";
            if($arr['0']->is_home==1){
                $result['is_home_selected']="checked";
            }
           
            $result['id']=$arr['0']->id;
            $result['category']=DB::table('categories')->where(['status'=>1])->where('id','!=', $id)->get();
         
        }else{
            $result['category_name']='';
            $result['category_slug']='';
            $result['parent_category_id']='';
            $result['category_image']='';
            // $result['status']=='';
            $result['is_home']='';
            $result['is_home_selected']='';
            $result['id']=0;
            $result['category']=DB::table('categories')->where(['status'=>1])->get();
          
        }

 
        return view('admin.manage_category',$result);
    }

    public function manage_category_insert(Request $request){
        if($request->post('id')>0){
            $image_validation="mimes:jpeg,jpg,png";
            
        }else{
            $image_validation="required|mimes:jpeg,jpg,png";
        }
       
            $request->validate([
                'category_name'=>'required',
                'category_image'=> $image_validation,
                'category_slug'=>'required|unique:categories,category_slug,'.$request->post('id'),
            ]);

         
            if($request->post('id')>0){
                $model = Category::find($request->post('id'));
                $mgs="อัพเดทเรียบร้อยแล้ว";
            }else{
                $model = new Category();
                $mgs="เพิ่มข้อมูลสำเร็จแล้ว";
              
            }
            if($request->hasFile('category_image')){
                if($request->post('id')>0){
                $arrImage=DB::table('categories')->where(['id'=>$request->post('id')])->get();
           
            if(Storage::exists('/public/media/category/'.$arrImage[0]->category_image)){
            Storage::delete('/public/media/category/'.$arrImage[0]->category_image);
            }
               
        }
    
                $image = $request->file('category_image');
                $ext=$image->extension();
                $image_name=time().'.'.$ext;
                $image->storeAs('/public/media/category',$image_name);
                $model->category_image=$image_name;
               
            }
          
            $model->category_name=$request->post('category_name');
            $model->category_slug=$request->post('category_slug');
            $model->parent_category_id=$request->post('parent_category_id');

            $model->is_home=0;
         
            if($request->post('is_home')!==null){
                $model->is_home=1;
            }
          
            $model->status=1;
            $model->save();

            $request->session()->flash('message', $mgs);

            return redirect('admin/category');
    }
   
    public function delete(Request $request,$id){
        $model = Category::find($id);
        Storage::exists('/public/media/category/'.$model->category_image);
            Storage::delete('/public/media/category/'.$model->category_image);
        $model->delete();
        $request->session()->flash('messagedelete','ลบรายการเรียบร้อยแล้ว');
        return redirect('admin/category');
     }


     public function status(Request $request,$status,$id){
         
        $test = Category::find($id);        
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
         
        return redirect('admin/category');
     }
  
}
