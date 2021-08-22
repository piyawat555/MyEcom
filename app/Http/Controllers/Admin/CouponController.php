<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['data']=Coupon::all(); 
        return view('admin.coupon',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_coupon(Request $request,$id='')
    {
        if($id>0){
            $arr=Coupon::where(['id'=>$id])->get();
            
            $result['title']=$arr['0']->title;
            $result['code']=$arr['0']->code;            
            $result['value']=$arr['0']->value;
            $result['type']=$arr['0']->type;
            $result['min_order_amt']=$arr['0']->min_order_amt;
            $result['is_one_time']=$arr['0']->is_one_time;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        
        }else{
            $result['title']='';
            $result['code']='';
            $result['value']='';
            $result['type']='';
            $result['min_order_amt']='';
            $result['is_one_time']='';
            $result['status']='';
            $result['id']=0;
        }

        return view('admin.manage_coupon',$result);
    }

    public function manage_coupon_insert(Request $request){
        // return $request->post();
            $request->validate([
                'title'=>'required',
                'code'=>'required|unique:coupons,code,'.$request->post('id'),
                'value'=>'required'
            ]);

         
            if($request->post('id')>0){
                $model = Coupon::find($request->post('id'));
                $mgs="อัพเดทคูปองเรียบร้อยแล้ว";
            }else{
                $model = new Coupon();
                $mgs="เพิ่มข้อมูลคูปองสำเร็จแล้ว";
                $model->status=1;
            }
            $model->title=$request->post('title');
            $model->code=$request->post('code');
            $model->value=$request->post('value');
            $model->type=$request->post('type');
            $model->min_order_amt=$request->post('min_order_amt');
            $model->is_one_time=$request->post('is_one_time');
     
            $model->save();

            $request->session()->flash('message', $mgs);

            return redirect('admin/coupon');
    }
   
    public function delete(Request $request,$id){
        
        $model = Coupon::find($id);
        $model->delete();
        $request->session()->flash('messagedelete','ลบคูปองเรียบร้อยแล้ว');
        return redirect('admin/coupon');
     }

     public function status(Request $request,$status,$id){

        $test = Coupon::find($id);        
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
         
        return redirect('admin/coupon');
     }


}
