@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Number</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" name="number" value="{{ old('number') }}">
                        @error('number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Agency Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="agency_name" value="{{ old('agency_name') }}">
                        @error('agency_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Lang</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="lang" value="{{ old('lang') }}">
                        @error('lang')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Profile</label>
                        <input type="file" class="form-control" id="exampleInputPassword1" name="profile">
                        @error('profile')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Role</label>
                        <select class="form-control" name="role">
                            <option value="">--Select--</option>
                            <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin</option>
                            <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Member</option>
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="plan_id" class="form-label">Plans</label>
                        <select class="form-control" id="plan_id" name="plan_id">
                            <option value="">--Select--</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                        @error('plan_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-check-label">Website</label>
                        <select class="form-control" name="status">
                            <option value=0>InActive</option>
                            <option value=1>Active</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="website" name="permissions[website]" {{ old('permissions.website') ? 'checked' : '' }}>
                        <label for="website" class="form-check-label">Website</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="publish_property" name="permissions[publish_property]" {{ old('permissions.publish_property') ? 'checked' : '' }}>
                        <label for="publish_properties" class="form-check-label">Publish Properties</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="information" name="permissions[real_estate]" {{ old('permissions.real_estate') ? 'checked' : '' }}>
                        <label for="information" class="form-check-label">Real Estate</label>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
