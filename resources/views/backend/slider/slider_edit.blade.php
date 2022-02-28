@extends('admin.admin_master')
@section('admin')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

      <!-- Main content -->
      <section class="content">
        <div class="row"> 
          <!-- /.col -->

          {{-- ------------- Edit Slider Page --------------------- --}}
          <div class="col-4">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Edit Slider</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                    <form method="POST" action="{{route('slider.update',$sliders->id)}}" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="id" value="{{$sliders->id}}">
                      <input type="hidden" name="old_image" value="{{$sliders->slider_img}}">
                      <div class="form-group">
                          <label for="exampleFormControlInput3">Slider Title</label>
                          <input type="text" name="title" class="form-control" value="{{$sliders->title}}">
                          @error('title')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Slider Description</label>
                          <input type="text" name="desciption" class="form-control" value="{{$sliders->desciption}}">
                          @error('desciption')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Slider Image</label>
                          <input type="file" name="slider_img" class="form-control">
                          @error('slider_img')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update">
                  </form>
                   </div>
               </div>
               <!-- /.box-body -->
             </div>
             <!-- /.box -->         
           </div>
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    
    </div>
</div>
<!-- /.content-wrapper -->

@endsection