@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    User Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"><b>Name</b></label>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Email</b> Address</label>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Number</b></label>
                        <p>{{ $user->number }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Agency</b> Name</label>
                        <p>{{ $user->agency_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Language</b></label>
                        <p>{{ $user->lang }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Profile</b></label>
                        @if($user->profile)
                        <p><img src="{{ asset('storage/' . $user->profile) }}" alt="Profile Picture" width="100"></p>
                        @else
                        <p>No profile picture uploaded.</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Role</b></label>
                        <p>{{ $user->role == 1 ? 'Admin' : 'Member' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Plan</b></label>
                        <p>{{ $user->plan->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Permissions</b></label>
                        <ul>
                            @if($user->permissions['website'])
                            <li>Website</li>
                            @endif
                            @if($user->permissions['publish_property'])
                            <li>Publish Properties</li>
                            @endif
                            @if($user->permissions['real_estate'])
                            <li>Real Estate</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection