@extends('layout')

@section('title','Settings')

@section('content')
  <div class="container-fluid py-2">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h4>Settings</h4>
        <hr>
        <div class="card-group">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User Info</h5>
              <form action="/update" method="post">
                @csrf
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name" value="{{session('account')->name}}" required>
                </div>
                <div class="form-group">
                  <label for="name">Email</label>
                  <input type="text" class="form-control" name="email" value="{{session('account')->email}}" required>
                </div>
                <button type="submit" class="btn btn-block btn-primary" name="button">Update</button>
              </form>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Password</h5>
              <form action="/password" method="post">
                @csrf
                <div class="form-group">
                  <label for="name">New Password</label>
                  <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                  <label for="name">Confirm New Password</label>
                  <input type="password" class="form-control" name="confirmpassword" required>
                </div>
                <button type="submit" class="btn btn-block btn-primary" name="button">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
