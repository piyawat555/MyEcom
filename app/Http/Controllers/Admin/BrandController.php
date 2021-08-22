<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Brand::all(); 
        return view('admin.brand',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_brand(Request $request,$id='')
    {
        if($id>0){
            $arr=Brand::where(['id'=>$id])->get();
          
            $result['name']=$arr['0']->name;
            $result['image']=$arr['0']->image;
            $result['status']=$arr['0']->status;
            $result['is_home']=$arr['0']->is_home;
            $result['is_home_selected']="";
            if($arr['0']->is_home==1){
                $result['is_home_selected']="checked";
            }
            $result['id']=$arr['0']->id;
        
        }else{
            $result['name']='';
            $result['image']='';
            $result['is_home']='';
            $result['is_home_selected']='';
            $result['status']='';
            $result['id']=0;
        }
  
        return view('admin.manage_brand',$result);
    }

    public function manage_brand_insert(Request $request){
        
   
            if($request->post('id')>0){
                $image_validation="mimes:jpeg,jpg,png";
                
            }else{
                $image_validation="required|mimes:jpeg,jpg,png";
            }
                $request->validate([
                    'name'=>'required|unique:brands,name,'.$request->post('id'),
                    'image'=> $image_validation,
                   
                ]);
               
        
            if($request->post('id')>0){
                $model = Brand::find($request->post('id'));
                $model->status=$request->post('status');
                $mgs="อัพเดทแบรนเรียบร้อยแล้ว";
            }else{
                $model = new Brand();
                $mgs="เพิ่มข้อมูลแบรนสำเร็จแล้ว";
                $model->status=1;
            }
            if($request->hasFile('image')){
                if($request->post('id')>0){
                    $arrImage=DB::table('brands')->where(['id'=>$request->post('id')])->get();
               
                if(Storage::exists('/public/media/brand/'.$arrImage[0]->image)){
                Storage::delete('/public/media/brand/'.$arrImage[0]->image);
                }
            }
                $image = $request->file('image');
                $ext=$image->extension();
                $image_name=time().'.'.$ext;
                $image->storeAs('/public/media/brand',$image_name);
                $model->image=$image_name;
            }
            // dd();
            $model->name=$request->post('name');
            $model->is_home=0;
         
            if($request->post('is_home')!==null){
                $model->is_home=1;
            }
          
            $model->save();

            $request->session()->flash('message', $mgs);

            return redirect('admin/brand');
    }
   
    public function delete(Request $request,$id){
       
        $model = Brand::find($id);
      
         Storage::exists('/public/media/brand/'.$model->image);
         Storage::delete('/public/media/brand/'.$model->image);
        $model->delete();
        $request->session()->flash('messagedelete','ลบแบรนเรียบร้อยแล้ว');
        return redirect('admin/brand');
     }

     public function status(Request $request,$status,$id){
         
        $test = Brand::find($id); 
           
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
         
        return redirect('admin/brand');
     }
}
