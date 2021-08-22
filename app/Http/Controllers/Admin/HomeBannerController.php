<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\HomeBanner;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class HomeBannerController extends Controller
{
    public function index()
    {
        $result['data']=HomeBanner::all(); 
        return view('admin.home_banner',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_home_banner(Request $request,$id='')
    {
        
        if($id>0){
            $arr=HomeBanner::where(['id'=>$id])->get();
            
            $result['image']=$arr['0']->image;
            $result['btn_txt']=$arr['0']->btn_txt;
            $result['btn_link']=$arr['0']->btn_link;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id; 
        }else{
            $result['image']='';
            $result['btn_txt']='';
            $result['btn_link']='';
            $result['status']='';
            $result['id']='';
        }

 
        return view('admin.manage_home_banner',$result);
    }

    public function manage_home_banner_insert(Request $request){
        if($request->post('id')>0){
            $image_validation="mimes:jpeg,jpg,png";
            
        }else{
            $image_validation="required|mimes:jpeg,jpg,png";
        }
       
            $request->validate([ 
                'image'=> $image_validation 
            ]);

         
            if($request->post('id')>0){
                $model = HomeBanner::find($request->post('id'));
                $mgs="อัพเดทเรียบร้อยแล้ว";
            }else{
                $model = new HomeBanner();
                $mgs="เพิ่มข้อมูลสำเร็จแล้ว";
              
            }
            if($request->hasFile('image')){
                if($request->post('id')>0){
                $arrImage=DB::table('home_banners')->where(['id'=>$request->post('id')])->get();
           
            if(Storage::exists('/public/media/banner/'.$arrImage[0]->image)){
            Storage::delete('/public/media/banner/'.$arrImage[0]->image);
            }
               
        }
    
                $image = $request->file('image');
                $ext=$image->extension();
                $image_name=time().'.'.$ext;
                $image->storeAs('/public/media/banner',$image_name);
                $model->image=$image_name;
               
            }
          
            $model->btn_txt=$request->post('btn_txt');
            $model->btn_link=$request->post('btn_link');
          
            $model->status=1;
            $model->save();

            $request->session()->flash('message', $mgs);

            return redirect('admin/home_banner');
    }
   
    public function delete(Request $request,$id){
        $model = HomeBanner::find($id);
        Storage::exists('/public/media/banner/'.$model->image);
            Storage::delete('/public/media/banner/'.$model->image);
        $model->delete();
        $request->session()->flash('messagedelete','ลบรายการเรียบร้อยแล้ว');
        return redirect('admin/home_banner');
     }


     public function status(Request $request,$status,$id){
         
        $test = HomeBanner::find($id);        
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
         
        return redirect('admin/home_banner');
     }
  
}
