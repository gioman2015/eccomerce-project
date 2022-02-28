<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Carbon\Carbon;

class SliderController extends Controller
{
    public function SliderView(){
		$sliders = Slider::latest()->get();
		return view('backend.slider.slider_view',compact('sliders'));
	}

    public function SliderStore(Request $request){
        $request->validate([
            'slider_image' => 'required',
        ],[
            'slider_image.required' => 'Plz Select One Image',
        ]);
        $image = $request->file('slider_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($image->getClientOriginalExtension());
        $img_name = $name_gen.".".$img_ext;
        $up_location = 'upload/slider/';
        $last_img = $up_location.$img_name;
        $image->move($up_location,$img_name);

        Slider::insert([
            'title' => $request->title,
            'desciption' => $request->desciption,
            'slider_img' => $last_img,
        ]);

        $notification = array(
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    public function SliderEdit($id){
        $sliders = Slider::findOrFail($id);
        return view('backend.slider.slider_edit', compact('sliders'));
    }

    public function SliderUpdate(Request $request){
        $slider_id = $request->id;
        $old_img = $request->old_image;
        $slider_image = $request->file('slider_img');

        if($slider_image){
            $image = $request->file('slider_img');
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($image->getClientOriginalExtension());
            $img_name = $name_gen.".".$img_ext;
            $up_location = 'upload/slider/';
            $last_img = $up_location.$img_name;
            $image->move($up_location,$img_name);
    
            unlink($old_img);
    
            Slider::findOrFail($slider_id)->update([
                'title' => $request->title,
                'desciption' => $request->desciption,
                'slider_img' => $last_img,
            ]);
            $notification = array(
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('manage-slider')->with($notification);
        }else{
            Slider::findOrFail($slider_id)->update([
                'title' => $request->title,
                'desciption' => $request->desciption,
                'slider_img' => $old_img,
            ]);
            $notification = array(
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('manage-slider')->with($notification);
        }
    }

    public function SliderDelete($id){

        $image = Slider::findOrFail($id);
        $old_image = $image->slider_img;
        unlink($old_image);

        Slider::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Slider Deleted Successfully',
            'alert-type' => 'error'
        );
        return redirect()->back()->with($notification);
    }

    public function SliderInactive($id){
        Slider::findOrFail($id)->update(['status' => 0]);
        $notification = array(
           'message' => 'Slider Inactive',
           'alert-type' => 'success'
       );
       return redirect()->back()->with($notification);
    }


    public function SliderActive($id){
        Slider::findOrFail($id)->update(['status' => 1]);
        $notification = array(
           'message' => 'Slider Active',
           'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
