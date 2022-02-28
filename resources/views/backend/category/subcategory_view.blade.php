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
                <h3 class="box-title">SubCategory List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                            <th>Category</th>
                            <th>SubCategory Name EN</th>
                            <th>SubCategory Name ESP</th>
                            <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($subcategories as $item)
                            <tr>
                                <td>{{$item['category']['category_name_en']}}</td>
                                <td>{{$item->subcategory_name_en}}</td>
                                <td>{{$item->subcategory_name_esp	}}</td>
                                <td width='30%'>
                                    <a href="{{route('subcategory.edit',$item->id)}}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('subcategory.delete',$item->id)}}" onclick="return confirm('Are you sure to delete')" class="btn btn-danger" title="Delete Data"><i class="fa fa-trash"></i> </a>
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

          {{-- ------------- Add SubCategory Page --------------------- --}}
          <div class="col-4">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Add SubCategory</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                    <form method="POST" action="{{route('subcategory.store')}}">
                      @csrf
                      <div class="form-group">
                        <h5>Category Select <span class="text-danger">*</span></h5>
                        <div class="controls">
                            <select name="category_id" id="select" required="" class="form-control">
                                <option value="" selected="" disable="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name_en}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                        </div>
                    </div>
                      <div class="form-group">
                          <label for="exampleFormControlInput3">SubCategory English</label>
                          <input type="text" name="subcategory_name_en" class="form-control">
                          @error('subcategory_name_en')
                              <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">SubCategory Spanish</label>
                          <input type="text" name="subcategory_name_esp" class="form-control">
                          @error('subcategory_name_esp')
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