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
            'subcategory_slug_en' => strtolower(str_replace(' ','-',$request->subcategory_name_en)),
            'subcategory_slug_esp' => strtolower(str_replace(' ','-',$request->subcategory_name_esp)),
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
        /* return $categories;
        die(); */
        return view('backend.category.subcategory_edit', compact('subcategory','categories'));
    }

    public function SubCategoryEdit(Request $request){
        $subcategory_id = $request->id;

        SubCategory::findOrFail($subcategory_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_esp' => $request->subcategory_name_esp,
            'subcategory_slug_en' => strtolower(str_replace(' ','-',$request->subcategory_name_en)),
            'subcategory_slug_esp' => strtolower(str_replace(' ','-',$request->subcategory_name_esp)),
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
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $subsubcategory = SubSubCategory::latest()->get();
        return view('backend.category.sub_subcategory_view',compact('subsubcategory','categories'));
    }


    public function GetSubCategory($category_id){
        $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name_en','ASC')->get();
        return json_encode($subcat);
    }


    public function GetSubSubCategory($subcategory_id){
        $subsubcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name_en','ASC')->get();
        return json_encode($subsubcat);
    }
    
    public function SubSubCategoryStore(Request $request){
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_name_en' => 'required',
            'subsubcategory_name_esp' => 'required',
        ],[
            'category_id.required' => 'Please select Any option',
            'subsubcategory_name_en.required' => 'Input SubSubCategory English Name',
        ]);
        SubSubCategory::insert([
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'subsubcategory_name_en' => $request->subsubcategory_name_en,
        'subsubcategory_name_esp' => $request->subsubcategory_name_esp,
        'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),
        'subsubcategory_slug_esp' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_esp)),
        ]); 
        $notification = array(
            'message' => 'Sub-SubCategory Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method 
 
    public function SubSubCategoryEdit($id){
        $categories = Category::orderBy('category_name_en','ASC')->get();
        $subcategories = SubCategory::orderBy('subcategory_name_en','ASC')->get();
        $subsubcategories = SubSubCategory::findOrFail($id);
        return view('backend.category.sub_subcategory_edit',compact('categories','subcategories','subsubcategories'));

    }
 
    public function SubSubCategoryUpdate(Request $request){

        $subsubcat_id = $request->id;

        SubSubCategory::findOrFail($subsubcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name_en' => $request->subsubcategory_name_en,
            'subsubcategory_name_esp' => $request->subsubcategory_name_esp,
            'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),
            'subsubcategory_slug_esp' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_esp)),
        ]);
        $notification = array(
            'message' => 'Sub-SubCategory Update Successfully',
            'alert-type' => 'info'
        );
        return redirect()->route('all.subsubcategory')->with($notification);
    } // end method 
 
 
    public function SubSubCategoryDelete($id){
        SubSubCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Sub-SubCategory Deleted Successfully',
            'alert-type' => 'info'
        );
        return redirect()->back()->with($notification);
    }
}
