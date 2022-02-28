<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function SubCategoryView(){
        $subcategories = SubCategory::latest()->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();
        return view('backend.category.subcategory_view', compact('subcategories','categories'));
    }

    public function SubCategoryStore(Request $request){
        $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_esp' => 'required',
        ],[
            'category_id.required' => 'Please Select Any Option',
            'subcategory_name_en.required' => 'Input SubCategory English Name',
            'subcategory_name_esp.required' => 'Input SubCategory Spanish Name',
        ]);

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_esp' => $request->subcategory_name_esp,
            'subcategory_slug_en' => strtolower(str_replace(' ','-',$request->subcategory_slug_en)),
            'subcategory_slug_esp' => strtolower(str_replace(' ','-',$request->subcategory_slug_esp)),
        ]);

        $notification = array(
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function SubCategoryUpdate($id){
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::orderBy('category_name_en','ASC')->get();
        return view('backend.category.subcategory_edit', compact('subcategory','categories'));
    }

    public function SubCategoryEdit(Request $request){
        $subcategory_id = $request->id;

        SubCategory::findOrFail($subcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_esp' => $request->subcategory_name_esp,
            'subcategory_slug_en' => strtolower(str_replace(' ','-',$request->subcategory_slug_en)),
            'subcategory_slug_esp' => strtolower(str_replace(' ','-',$request->subcategory_slug_esp)),
        ]);
        $notification = array(
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'info'
        );
        return redirect()->route('all.subcategory')->with($notification);
    }

    public function SubCategoryDelete($id){
        SubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

/*--------------------- Sub SubCategory --------------------*/

    public function SubSubCategoryView(){
        $subsubcategories = SubSubCategory::latest()->get();
        $categories = Category::orderBy('category_name_en','ASC')->get();
        return view('backend.category.subsubcategory_view', compact('subsubcategories','categories'));
    }

    public function GetSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name_en','ASC')->get();
        return json_encode($subcat);
    }
}
