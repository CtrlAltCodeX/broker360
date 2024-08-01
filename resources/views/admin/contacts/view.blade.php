@extends('admin.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Contact Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Name:</strong></label>
                            <p>{{ $contact->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Last Name:</strong></label>
                            <p>{{ $contact->last_name }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Position:</strong></label>
                            <p>{{ $contact->position }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Company:</strong></label>
                            <p>{{ $contact->company }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Fountain:</strong></label>
                            <p>{{ $contact->fountain }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Number:</strong></label>
                            <p>{{ $contact->number }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Email Address:</strong></label>
                            <p>{{ $contact->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Twitter:</strong></label>
                            <p>{{ $contact->twitter }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>LinkedIn:</strong></label>
                            <p>{{ $contact->linkedin }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Skype:</strong></label>
                            <p>{{ $contact->skype }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Website:</strong></label>
                            <p>{{ $contact->website }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Address:</strong></label>
                            <p>{{ $contact->address }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><strong>Description:</strong></label>
                            <p>{{ $contact->description }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><strong>User:</strong></label>
                            <p>{{ $contact->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection