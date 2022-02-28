@extends('admin.admin_master')
@section('admin')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">

      <!-- Main content -->
      <section class="content">
        <div class="row">    

          <div class="col-8">

           <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Category List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                            <th>Icon</th>
                            <th>Category Name EN</th>
                            <th>Category Name ESP</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($categories as $item)
                            <tr>
                                <td><span><i class="{{$item->category_icon}}"></i></span> </td>
                                <td>{{$item->category_name_en}}</td>
                                <td>{{$item->category_name_esp	}}</td>
                                <td>
                                    <a href="{{route('category.edit',$item->id)}}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('category.delete',$item->id)}}" onclick="return confirm('Are you sure to delete')" class="btn btn-danger" title="Delete Data"><i class="fa fa-trash"></i> </a>
                                </td>
                            </tr> 
                          @endforeach
                          
                      </tbody>
                    </table>
                  </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->         
          </div>
          <!-- /.col -->

          {{-- ------------- Add Category Page --------------------- --}}
          <div class="col-4">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Add Category</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                    <form method="POST" action="{{route('category.store')}}">
                      @csrf
                      <div class="form-group">
                          <label for="exampleFormControlInput3">Category English</label>
                          <input type="text" name="category_name_en" class="form-control">
                          @error('category_name_en')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Category Spanish</label>
                          <input type="text" name="category_name_esp" class="form-control">
                          @error('category_name_esp')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlPassword3">Category Icon</label>
                        <input type="text" name="category_icon" class="form-control">
                        @error('category_icon')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                      <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add new">
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