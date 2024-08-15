@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-3">
        <div class="col-md-6">
            <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" value="{{ old('name', $user->name) }}" name="name">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" value="{{ old('email', $user->email) }}" name="email">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                        <span>Leave Blank if do not want to change</span>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Number</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" value="{{ old('number', $user->number) }}" name="number">
                        @error('number')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Agency Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" value="{{ old('agency_name', $user->agency_name) }}" name="agency_name">
                        @error('agency_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Lang</label>
                        <select class="form-control" name="lang">
                            <option value="" disabled="">Seleccionar</option>
                            <option value="es" {{ $user->lang == "es" ? 'selected' : '' }}>Español</option>
                            <option value="en" {{ $user->lang == "en" ? 'selected' : '' }}>English</option>
                            <option value="fr" {{ $user->lang == "fr" ? 'selected' : '' }}>Français</option>
                            <option value="de" {{ $user->lang == "de" ? 'selected' : '' }}>Deutsch</option>
                        </select>
                        <!-- <input type="text" class="form-control" id="exampleInputPassword1" value="{{ old('lang', $user->lang) }}" name="lang"> -->
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
                            <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="0" {{ old('role', $user->role) == 0 ? 'selected' : '' }}>Member</option>
                        </select>
                        @error('role')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Plans</label>
                        <select class="form-control" id="plan_id" name="plan_id">
                            <option value="">--Select--</option>
                            @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id', $user->permissions?->plan_id) == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                        @error('plan_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-check-label">Website</label>
                        <select class="form-control" name="status">
                            <option value=0 {{ $user->status == 0 ? 'selected' : '' }}>InActive</option>
                            <option value=1 {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="website" name="permissions[website]" {{ old('permissions.website', $user->permissions?->website) ? 'checked' : '' }}>
                        <label for="website" class="form-check-label">Website</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="publish_properties" name="permissions[publish_property]" {{ old('permissions.publish_property', $user->permissions?->publish_property) ? 'checked' : '' }}>
                        <label for="publish_properties" class="form-check-label">Publish Properties</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="information" name="permissions[real_estate]" {{ old('permissions.real_estate', $user->permissions?->real_estate) ? 'checked' : '' }}>
                        <label for="information" class="form-check-label">Information</label>
                    </div>
                </div> <!--end::Body-->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection