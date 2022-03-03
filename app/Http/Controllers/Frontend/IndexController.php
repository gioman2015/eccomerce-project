<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Product;
use App\Models\MultiImg;

class IndexController extends Controller
{
    public function index(){
        $products = Product::where('status','1')->orderBy('id','DESC')->limit(6)->get();
        $sliders = Slider::where('status','1')->orderBy('id','DESC')->limit(3)->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $featured = Product::where([['featured','1'],['status','1']])->orderBy('id','DESC')->limit(6)->get();
        $hot_deals = Product::where([['hot_deals','1'],['status','1'],['discount_price','!=', NULL]])->orderBy('id','DESC')->limit(3)->get();
        $special_offer = Product::where([['special_offer','1'],['status','1']])->orderBy('id','DESC')->limit(6)->get();
        $special_deals = Product::where([['special_deals','1'],['status','1']])->orderBy('id','DESC')->limit(3)->get();
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where([['status','1'],['category_id',$skip_category_0->id]])->orderBy('id','DESC')->limit(3)->get();
        /* return $skip_category->id;
        die(); */
        return view('frontend.index', compact('categories','sliders','products','featured','hot_deals','special_offer','special_deals','skip_category_0','skip_product_0'));
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

    public function ProductDetails($id,$slug){
		$product = Product::findOrFail($id);

        $color_en = $product->product_color_en;
        $product_color_en = explode(',', $color_en);
        $color_esp = $product->product_color_esp;
        $product_color_esp = explode(',', $color_esp);
        $size_en = $product->product_size_en;
        $product_size_en = explode(',', $size_en);
        $size_esp = $product->product_size_esp;
        $product_size_esp = explode(',', $size_esp);
        $multiImag = MultiImg::where('product_id',$id)->get();

        $cat_id = $product->category_id;
        $relatedProduct = Product::where([['category_id',$cat_id],['id','!=',$id]])->orderBy('id','DESC')->get();
	 	return view('frontend.product.product_details',compact('product','multiImag','product_color_en','product_color_esp','product_size_en','product_size_esp','relatedProduct'));
	}

    public function TagWiseProduct($tag){
		$products = Product::where([['status',1],['product_tags_en',$tag],['product_tags_esp',$tag]])->orderBy('id','DESC')->paginate(3);
        $categories = Category::orderBy('category_name_en','ASC')->get();
		return view('frontend.tags.tags_view',compact('products','categories'));
	}

    public function SubCatWiseProduct($subcat_id, $slug){
        $products = Product::where([['status',1],['subcategory_id',$subcat_id]])->orderBy('id','DESC')->paginate(6);
        $categories = Category::orderBy('category_name_en','ASC')->get();
		return view('frontend.product.subcategory_view',compact('products','categories'));
    }

    public function SubSubCatWiseProduct($subsubcat_id, $slug){
        $products = Product::where([['status',1],['subsubcategory_id',$subsubcat_id]])->orderBy('id','DESC')->paginate(6);
        $categories = Category::orderBy('category_name_en','ASC')->get();
		return view('frontend.product.sub_subcategory_view',compact('products','categories'));
    }

    /// Product View With Ajax
	public function ProductViewAjax($id){
        $product = Product::with('category','brand')->findOrFail($id);

		/* $color = $product->product_color_en;
		$product_color = explode(',', $color);

		$size = $product->product_size_en;
		$product_size = explode(',', $size); */

        $color_en = $product->product_color_en;
        $product_color_en = explode(',', $color_en);
        $color_esp = $product->product_color_esp;
        $product_color_esp = explode(',', $color_esp);
        $size_en = $product->product_size_en;
        $product_size_en = explode(',', $size_en);
        $size_esp = $product->product_size_esp;
        $product_size_esp = explode(',', $size_esp);

		return response()->json(array(
			'product' => $product,
			'coloren' => $product_color_en,
			'sizeen' => $product_size_en,
            'coloresp' => $product_color_esp,
			'sizeesp' => $product_size_esp,
		));
	} // end method
}
