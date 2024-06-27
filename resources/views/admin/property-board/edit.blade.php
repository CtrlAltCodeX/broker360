@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-3">
        <div class="col-md-6">
            <form action="{{ route('admin.boards.update', $boards->id) }}" method="post"> <!--begin::Body-->
                @csrf
                <div class="card-body">
                    <div class="mb-3"> <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $boards->name }}" name="name">
                    </div>
                    <div>
                        <label>Users</label>
                        <select class="form-control mb-2" name="user_id">
                            <option value="">--Select--</option>
                            @foreach($allUsers as $user)
                            <option value="{{$user->id}}" {{ $boards->user_id == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection