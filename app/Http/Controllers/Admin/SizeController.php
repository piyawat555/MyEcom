<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Size::all(); 
        return view('admin.size',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_size(Request $request,$id='')
    {
        if($id>0){
            $arr=Size::where(['id'=>$id])->get();
            
            $result['size']=$arr['0']->size;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        
        }else{
            $result['size']='';
            $result['status']='';
            $result['id']='';
        }

        return view('admin.manage_size',$result);
    }

    public function manage_size_insert(Request $request){
      
            $request->validate([
                'size'=>'required|unique:sizes,size,'.$request->post('id'),
               
            ]);
           
         
            if($request->post('id')>0){
                $model = Size::find($request->post('id'));
              
                $mgs="อัพเดทไซด์เรียบร้อยแล้ว";
            }else{
                $model = new Size();
                $mgs="เพิ่มข้อมูลไซด์สำเร็จแล้ว";
               
            }
      
            $model->size=$request->post('size');
            $model->status=0;
            $model->save();

            $request->session()->flash('message', $mgs);

            return redirect('admin/size');
    }
   
    public function delete(Request $request,$id){
        
        $model = Size::find($id);
        $model->delete();
        $request->session()->flash('messagedelete','ลบไซด์เรียบร้อยแล้ว');
        return redirect('admin/size');
     }

     public function status(Request $request,$status,$id){
         
        $test = Size::find($id); 
           
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
         
        return redirect('admin/size');
     }
}
