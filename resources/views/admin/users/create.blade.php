@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data"> <!--begin::Body-->
            @csrf
                <div class="card-body">
                    <div class="mb-3"> <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="name">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" name="email">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Number</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" name="number">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Agency Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="agency_name">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Lang</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="lang">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Profile</label>
                        <input type="file" class="form-control" id="exampleInputPassword1" name="profile">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Role</label>
                        <select class="form-control">
                            <option value="">--Select--</option>
                            <option value=1 >Admin</option>
                            <option value=0 >Member</option>
                        </select>
                    </div>

                </div> <!--end::Body--> <!--begin::Footer-->
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection