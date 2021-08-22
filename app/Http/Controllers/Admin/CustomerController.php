<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $result['data']=Customer::all(); 
        return view('admin.customers',$result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id='')
    {
        $arr=Customer::where(['id'=>$id])->get();
 
        $result['name']=$arr['0']->name;
        $result['email']=$arr['0']->email;
        $result['mobile']=$arr['0']->mobile;
        $result['password']=$arr['0']->password;
        $result['address']=$arr['0']->address;
        $result['city']=$arr['0']->city;
        $result['state']=$arr['0']->state;
        $result['zip']=$arr['0']->zip;
        $result['company']=$arr['0']->company;
        $result['gstin']=$arr['0']->gstin;
        $result['status']=$arr['0']->status;
        $result['created_at']=$arr['0']->created_at;
        $result['updated_at']=$arr['0']->updated_at;
        $result['id']=$arr['0']->id;  
        return view('admin.show_customers',$result);
    }
  
     public function status(Request $request,$status,$id){
         
        $test = Customer::find($id); 
           
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
         
        return redirect('admin/customers');
     }
}
