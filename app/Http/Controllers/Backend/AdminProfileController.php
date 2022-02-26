<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function AdminProfile(){
        $adminData = Admin::find(1);
        return view('admin.admin_profile_view', compact('adminData'));
    }

    public function AdminProfileEdit(){
        $editData = Admin::find(1);
        return view('admin.admin_profile_edit', compact('editData'));  
    }

    public function AdminProfileStore(Request $request){
        $data = Admin::find(1);
        $data->name = $request->name;
        $data->email = $request->email;
        
        if($request->file('profile_photo_path')){
            $old_image = $data->profile_photo_path;         
            $brand_image = $request->file('profile_photo_path');
            unlink($old_image);
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.".".$img_ext;
            $up_location = 'upload/admin_images/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);
            $data['profile_photo_path'] = $last_img;

        } 
        $data->save();

        $notification = array(
            'message' => "Admin Profile Updated Successfully",
            'alert-type' => 'success'
        );
        return redirect()->route('admin.profile')->with($notification);
    }

    public function ChangePassword(){
        return view('admin.admin_change_password');
    }

    public function AdminUpdateChangePassword(Request $request){
        $validateData = $request->validate([
            'oldpassword'=>'required',
            'password'=>'required|confirmed',
        ]);
        $hashedPassword = Admin::find(1)->password;
        if(Hash::check($request->oldpassword, $hashedPassword)){
            $admin = Admin::find(1);
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::logout();
            return redirect()->route('admin.logout')->with('success', 'Password is Change Successfuly');
        }else{
            return redirect()->back()->with('error', 'Current Password is invalid');
        }
    }
}
