<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Tax::all(); 
        return view('admin.tax',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_tax(Request $request,$id='')
    {
        if($id>0){
            $arr=Tax::where(['id'=>$id])->get();
            
            $result['tax_desc']=$arr['0']->tax_desc;
            $result['tax_value']=$arr['0']->tax_value;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        
        }else{
            $result['tax_desc']='';
            $result['tax_value']='';
            $result['status']='';
            $result['id']=0;
        }

        return view('admin.manage_tax',$result);
    }

    public function manage_tax_insert(Request $request){
      
            $request->validate([
                'tax_value'=>'required|unique:taxs,tax_value,'.$request->post('id'),
            ]);
           
         
            if($request->post('id')>0){
                $model = Tax::find($request->post('id'));
              
                $mgs="อัพเดทแท็กเรียบร้อยแล้ว";
            }else{
                $model = new Tax();
                $mgs="เพิ่มข้อมูลแท็กสำเร็จแล้ว";
                $model->status=1;
            }
            $model->tax_desc=$request->post('tax_value');
            $model->tax_value=$request->post('tax_value');
          
            $model->save();

            $request->session()->flash('message', $mgs);

            return redirect('admin/tax');
    }
   
    public function delete(Request $request,$id){
        
        $model = Tax::find($id);
        $model->delete();
        $request->session()->flash('messagedelete','ลบสีเรียบร้อยแล้ว');
        return redirect('admin/tax');
     }

     public function status(Request $request,$status,$id){
         
        $test = Tax::find($id); 
           
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
         
        return redirect('admin/tax');
     }
 
}
