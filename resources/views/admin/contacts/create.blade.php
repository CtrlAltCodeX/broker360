@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form action="{{ route('admin.contacts.store') }}" method="post" enctype="multipart/form-data"> <!--begin::Body-->
            @csrf
                <div class="card-body">
                <div class="mb-3"> <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="name">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="last_name">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Postion</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="position">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Company</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" name="company">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Fouuntain</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="fountain">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Number</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" name="number">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" name="email">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Twitter</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="twitter">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Linkedin</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="linkedin">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Skype</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="skype">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Website</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="website">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Address</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="address">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Description</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="description">
                    </div>

                </div> <!--end::Body--> <!--begin::Footer-->
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection