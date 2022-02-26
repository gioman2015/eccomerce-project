<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index(){
        return view('frontend.index');
    }

    public function UserLogout(){
        Auth::logout();
        return Redirect()->route('login');
    }

    public function UserProfile(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.user_profile', compact('user'));
    }

    public function UserProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        
        if($request->file('profile_photo_path')){
            $old_image = $data->profile_photo_path;         
            $brand_image = $request->file('profile_photo_path');
            if($old_image){
                unlink($old_image);
            }
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen.".".$img_ext;
            $up_location = 'upload/user_images/';
            $last_img = $up_location.$img_name;
            $brand_image->move($up_location,$img_name);
            $data['profile_photo_path'] = $last_img;

        } 
        $data->save();

        $notification = array(
            'message' => "User Profile Updated Successfully",
            'alert-type' => 'success'
        );
        return redirect()->route('dashboard')->with($notification);
    }

    public function ChangePassword(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password', compact('user'));
    }

    public function UserPasswordUpdate(Request $request){
        $validateData = $request->validate([
            'oldpassword'=>'required',
            'password'=>'required|confirmed',
        ]);
        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword, $hashedPassword)){
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('user.logout')->with('success', 'Password is Change Successfuly');
        }else{
            return redirect()->back()->with('error', 'Current Password is invalid');
        }
    }
}
