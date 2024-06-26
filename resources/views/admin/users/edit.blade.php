@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-3">
        <div class="col-md-6">
            <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data"> <!--begin::Body-->
                @csrf
                <div class="card-body">
                    <div class="mb-3"> <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $user->name }}" name="name">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" value="{{ $user->email }}" name="email">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" value="{{ $user->password }}" name="password">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Number</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" value="{{ $user->number }}" name="number">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Agency Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" value="{{ $user->agency_name }}" name="agency_name">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Lang</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" value="{{ $user->lang }}" name="lang">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Profile</label>
                        <input type="file" class="form-control" id="exampleInputPassword1" value="{{ $user->profile }}" name="profile">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Role</label>
                        <select class="form-control">
                            <option value="">--Select--</option>
                            <option value=1 {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                            <option value=0 {{ $user->role == 0 ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection