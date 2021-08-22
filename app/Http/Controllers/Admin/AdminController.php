<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return view('admin.login');
        }
 
    }

    public function auth(Request $request)
    {
            $email=$request->post('email');
           

            $result=Admin::where(['email'=>$email])->first();
           
            if($result){

                if(Hash::check($request->post('password'),$result->password)){
                  
                    $request->session()->put('ADMIN_LOGIN',true);
                    $request->session()->put('ADMIN_ID',$result->id);
                    $request->session()->flash('loginsuccess','เข้าสู่ระบบสำเร็จแล้ว ');
                    return redirect('admin/dashboard');
                }else{
                    $request->session()->flash('error','รหัสผ่านหรืออีเมลล์ของคุณไม่ถูกต้อง');
                    return redirect('admin');
                }
               
            }else{
                $request->session()->flash('error','รหัสผ่านหรืออีเมลล์ของคุณไม่ถูกต้อง');
                return redirect('admin');
            }

    }


    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout()
    {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('success','ออกจากระบบแล้ว');
        return redirect('admin');
    }

    // public function updatepassword(){
    //     $r=Admin::find(1);
       
    //     $r->password=Hash::make('aaaaaaaa');
    //     $r->save();
    // }

 


}
