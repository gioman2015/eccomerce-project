@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="content-wrapper">
    <div class="container-full">

      <!-- Main content -->
      <section class="content">
          <div class="row">
              
            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">User Change Password</h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form method="POST" action="{{route('update.change.password')}}" class="form-pill">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleFormControlInput3">Current Password</label>
                                    <input type="password" id="current_password" name="oldpassword" class="form-control" placeholder="Current Password">
                                    @error('oldpassword')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlPassword3">New Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="New Password">
                                    @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlPassword3">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary btn-default" type="submit">Save</button>
                            </form>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
      </section>
      <!-- /.content -->
    </div>
</div>

@endsection