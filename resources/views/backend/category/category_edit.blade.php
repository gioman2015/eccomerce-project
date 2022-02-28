@extends('admin.admin_master')
@section('admin')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

      <!-- Main content -->
      <section class="content">
        <div class="row">    


          {{-- ------------- Add Category Page --------------------- --}}
          <div class="col-12">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Add Category</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                    <form method="POST" action="{{route('category.update')}}">
                      @csrf
                      <input type="hidden" name="id" value="{{$category->id}}">
                      <div class="form-group">
                          <label for="exampleFormControlInput3">Category English</label>
                          <input type="text" name="category_name_en" class="form-control" value="{{$category->category_name_en}}">
                          @error('category_name_en')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Category Spanish</label>
                          <input type="text" name="category_name_esp" class="form-control"  value="{{$category->category_name_esp}}">
                          @error('category_name_esp')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlPassword3">Category Icon</label>
                        <input type="text" name="category_icon" class="form-control"  value="{{$category->category_icon}}">
                        @error('category_icon')
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