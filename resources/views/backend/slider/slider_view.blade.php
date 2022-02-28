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
                <h3 class="box-title">Slider List</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>Slider Image</th>
                              <th>Title</th>
                              <th>Description</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($sliders as $item)
                            <tr>
                                <td><img src="{{asset($item->slider_img)}}" style="width: 70px"></td>
                                <td>
                                    @if ($item->title == null)
                                        <span class="badge badge-pill badge-danger">No Title</span>  
                                    @else
                                        {{$item->title}}
                                    @endif 
                                </td>
                                <td>{{$item->desciption	}}</td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="badge badge-pill badge-success">Active</span>  
                                    @else
                                        <span class="badge badge-pill badge-danger">InActive</span> 
                                    @endif    
                                </td>
                                <td>
                                    <a href="{{route('slider.edit',$item->id)}}" class="btn btn-info" title="Edit Data"><i class="fa fa-pencil"></i></a>
                                    <a href="{{route('slider.delete',$item->id)}}" onclick="return confirm('Are you sure to delete')" class="btn btn-danger" title="Delete Data"><i class="fa fa-trash"></i> </a>
                                    @if($item->status == 1)
                                        <a href="{{ route('slider.inactive',$item->id) }}" class="btn btn-danger" title="Inactive Now"><i class="fa fa-arrow-down"></i> </a>
                                    @else
                                        <a href="{{ route('slider.active',$item->id) }}" class="btn btn-success" title="Active Now"><i class="fa fa-arrow-up"></i> </a>
                                    @endif
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

          {{-- ------------- Add Slider Page --------------------- --}}
          <div class="col-4">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Add Slider</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                    <form method="POST" action="{{route('slider.store')}}" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                          <label for="exampleFormControlInput3">Slider Title</label>
                          <input type="text" name="title" class="form-control">
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Slider Description</label>
                          <input type="text" name="desciption" class="form-control">
                      </div>
                      <div class="form-group">
                          <label for="exampleFormControlPassword3">Slider Image</label>
                          <input type="file" name="slider_image" class="form-control">
                          @error('slider_image')
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