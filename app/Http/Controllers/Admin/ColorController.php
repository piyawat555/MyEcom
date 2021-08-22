<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Color::all(); 
        return view('admin.color',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_color(Request $request,$id='')
    {
        if($id>0){
            $arr=Color::where(['id'=>$id])->get();
            
            $result['color']=$arr['0']->color;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        
        }else{
            $result['color']='';
            $result['status']='';
            $result['id']=0;
        }

        return view('admin.manage_color',$result);
    }

    public function manage_color_insert(Request $request){
      
            $request->validate([
                'color'=>'required|unique:colors,color,'.$request->post('id'),
            ]);
           
         
            if($request->post('id')>0){
                $model = Color::find($request->post('id'));
              
                $mgs="อัพเดทสีเรียบร้อยแล้ว";
            }else{
                $model = new Color();
                $mgs="เพิ่มข้อมูลสีสำเร็จแล้ว";
               
            }
            $model->color=$request->post('color');
            $model->status=0;
            $model->save();

            $request->session()->flash('message', $mgs);

            return redirect('admin/color');
    }
   
    public function delete(Request $request,$id){
        
        $model = Color::find($id);
        $model->delete();
        $request->session()->flash('messagedelete','ลบสีเรียบร้อยแล้ว');
        return redirect('admin/color');
     }

     public function status(Request $request,$status,$id){
         
        $test = Color::find($id); 
           
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
         
        return redirect('admin/color');
     }
 
}
