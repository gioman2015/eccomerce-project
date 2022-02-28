@extends('admin.admin_master')
@section('admin')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

      <!-- Main content -->
      <section class="content">
        <div class="row"> 
          <!-- /.col -->

          {{-- ------------- Edit Brand Page --------------------- --}}
          <div class="col-4">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Edit Brand</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                    <form method="POST" action="{{route('brand.update',$brand->id)}}" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="id" value="{{$brand->id}}">
                      <input type="hidden" name="old_image" value="{{$brand->brand_image}}">
                      <div class="form-group">
                          <label for="exampleFormControlInput3">Brand Name English</label>
                          <input type="text" name="brand_name_en" class="form-control" value="{{$brand->brand_name_en}}">
                          @error('brand_name_en')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Brand Name Spanish</label>
                          <input type="text" name="brand_name_esp" class="form-control" value="{{$brand->brand_name_esp}}">
                          @error('brand_name_esp')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Brand Image</label>
                          <input type="file" name="brand_image" class="form-control">
                          @error('brand_image')
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