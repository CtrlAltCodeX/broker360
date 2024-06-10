@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form action="{{ route('admin.boards.store') }}" method="post" enctype="multipart/form-data"> <!--begin::Body-->
                @csrf
                <div class="card-body">
                    <div class="mb-3"> <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="name">
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection