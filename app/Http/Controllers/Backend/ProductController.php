<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\Product;
use App\Models\MultiImg;
use Carbon\Carbon;


class ProductController extends Controller
{
    public function AddProduct(){
        $categories = Category::latest()->get();
		$brands = Brand::latest()->get();
		return view('backend.product.product_add',compact('categories','brands'));
    }

    public function StoreProduct(Request $request){
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($image->getClientOriginalExtension());
        $img_name = $name_gen.".".$img_ext;
        $up_location = 'upload/products/thambnail/';
        $last_img = $up_location.$img_name;
        $image->move($up_location,$img_name);
        
        $product_id = Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => '1'/* $request->subcategory_id */,
            'subsubcategory_id' => '1'/* $request->subsubcategory_id */,
            'product_name_en' => $request->product_name_en,
            'product_name_esp' => $request->product_name_esp,
            'product_slug_en' => strtolower(str_replace(' ','-',$request->product_name_en)),
            'product_slug_esp' => strtolower(str_replace(' ','-',$request->product_name_esp)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_esp' => $request->product_tags_esp,
            'product_size_en' => $request->product_size_en,
            'product_size_esp' => $request->product_size_esp,
            'product_color_en' => $request->product_color_en,
            'product_color_esp' => $request->product_color_esp,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_esp' => $request->short_descp_esp,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_esp' => $request->long_descp_esp,
            'hot_deals' => $request->hot_deals,

            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'product_thambnail' => $last_img,
            'status' => 1,
            'created_at' => Carbon::now(), 
        ]);

        ////////// Multiple Image Upload Start ///////////

        $multi_imgs = $request->file('multi_img');

        foreach($multi_imgs as $multi_img){
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($multi_img->getClientOriginalExtension());
            $img_name = $name_gen.".".$img_ext;
            $up_location = 'upload/products/multi-image/';
            $last_img = $up_location.$img_name;
            $multi_img->move($up_location,$img_name);

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $last_img,
                'created_at' => Carbon::now()
            ]);
        }
        //End Foreach
        ////////// Multiple Image Upload End ///////////
        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );
        return Redirect()->route('manage-product')->with($notification);
    }

    public function ManageProduct(){
        $products = Product::latest()->get();
        return view('backend.product.view_product', compact('products'));
    }

    public function EditProduct($id){
        $multiImgs = MultiImg::where('product_id',$id)->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $subsubcategory = SubSubCategory::latest()->get();
        $brands = Brand::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.product_edit', compact('categories','subcategory','subsubcategory','brands','products','multiImgs'));
    }

    public function ProductDataUpdate(Request $request){
        $product_id = $request->id;
        Product::findOrFail($product_id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_name_en' => $request->product_name_en,
            'product_name_esp' => $request->product_name_esp,
            'product_slug_en' => strtolower(str_replace(' ','-',$request->product_name_en)),
            'product_slug_esp' => strtolower(str_replace(' ','-',$request->product_name_esp)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_esp' => $request->product_tags_esp,
            'product_size_en' => $request->product_size_en,
            'product_size_esp' => $request->product_size_esp,
            'product_color_en' => $request->product_color_en,
            'product_color_esp' => $request->product_color_esp,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_esp' => $request->short_descp_esp,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_esp' => $request->long_descp_esp,
            'hot_deals' => $request->hot_deals,

            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => 1,
            'created_at' => Carbon::now(), 
        ]);

        $notification = array(
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        );
        return Redirect()->route('manage-product')->with($notification);
    }//end method

    /// Multiple Image Update
	public function MultiImageUpdate(Request $request){
		$imgs = $request->multi_img;

		foreach ($imgs as $id => $img) {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($img->getClientOriginalExtension());
            $img_name = $name_gen.".".$img_ext;
            $up_location = 'upload/products/multi-image/';
            $last_img = $up_location.$img_name;
            $img->move($up_location,$img_name);

            MultiImg::where('id',$id)->update([
                'photo_name' => $last_img,
                'updated_at' => Carbon::now(),
            ]);
        }
        $notification = array(
			'message' => 'Product Image Updated Successfully',
			'alert-type' => 'info'
		);
		return redirect()->back()->with($notification);
	} // end mehtod

    /// Product Main Thambnail Update /// 
    public function ThambnailImageUpdate(Request $request){
        $pro_id = $request->id;
        $oldImage = $request->old_img;
        unlink($oldImage);

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($image->getClientOriginalExtension());
        $img_name = $name_gen.".".$img_ext;
        $up_location = 'upload/products/thambnail/';
        $last_img = $up_location.$img_name;
        $image->move($up_location,$img_name);

        Product::findOrFail($pro_id)->update([
           'product_thambnail' => $last_img,
           'updated_at' => Carbon::now(),

        ]);
        $notification = array(
           'message' => 'Product Image Thambnail Updated Successfully',
           'alert-type' => 'info'
       );
       return redirect()->back()->with($notification);
    } // end method

    //// Multi Image Delete ////
    public function MultiImageDelete($id){
        $oldimg = MultiImg::findOrFail($id);
        unlink($oldimg->photo_name);
        MultiImg::findOrFail($id)->delete();
        $notification = array(
           'message' => 'Product Image Deleted Successfully',
           'alert-type' => 'success'
       );
       return redirect()->back()->with($notification);
    } // end method

    public function ProductInactive($id){
        Product::findOrFail($id)->update(['status' => 0]);
        $notification = array(
           'message' => 'Product Inactive',
           'alert-type' => 'success'
       );
       return redirect()->back()->with($notification);
    }


    public function ProductActive($id){
        Product::findOrFail($id)->update(['status' => 1]);
        $notification = array(
           'message' => 'Product Active',
           'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function ProductDelete($id){
        $product = Product::findOrFail($id);
        unlink($product->product_thambnail);
        Product::findOrFail($id)->delete();

        $images = MultiImg::where('product_id',$id)->get();
        foreach ($images as $img) {
            unlink($img->photo_name);
            MultiImg::where('product_id',$id)->delete();
        }

        $notification = array(
           'message' => 'Product Deleted Successfully',
           'alert-type' => 'success'
       );
       return redirect()->back()->with($notification);
    }// end method 
}
