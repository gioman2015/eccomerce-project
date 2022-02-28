<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Image;

class CategoryController extends Controller
{
    public function CategoryView(){
        $categories = Category::latest()->get();
        return view('backend.category.category_view', compact('categories'));
    }

    public function CategoryStore(Request $request){
        $request->validate([
            'category_name_en' => 'required',
            'category_name_esp' => 'required',
            'category_icon' => 'required',
        ],[
            'category_name_en.required' => 'Input Category English Name',
            'category_name_esp.required' => 'Input Category Spanish Name',
        ]);

        Category::insert([
            'category_name_en' => $request->category_name_en,
            'category_name_esp' => $request->category_name_esp,
            'category_slug_en' => strtolower(str_replace(' ','-',$request->category_slug_en)),
            'category_slug_esp' => strtolower(str_replace(' ','-',$request->category_slug_esp)),
            'category_icon' => $request->category_icon,
        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function CategoryUpdate($id){
        $category = Category::findOrFail($id);
        return view('backend.category.category_edit', compact('category'));
    }

    public function CategoryEdit(Request $request){
        $category_id = $request->id;

        Category::findOrFail($category_id)->update([
            'category_name_en' => $request->category_name_en,
            'category_name_esp' => $request->category_name_esp,
            'category_slug_en' => strtolower(str_replace(' ','-',$request->category_slug_en)),
            'category_slug_esp' => strtolower(str_replace(' ','-',$request->category_slug_esp)),
            'category_icon' => $request->category_icon,
        ]);
        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.category')->with($notification);
    }

    public function CategoryDelete($id){
        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }
}
