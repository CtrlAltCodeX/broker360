@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-3">
        <div class="col-md-6">
            <form action="{{ route('admin.contacts.update', $contact->id) }}" method="post"> <!--begin::Body-->
            @csrf
                <div class="card-body">
                    <div class="mb-3"> <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{ $contact->name }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="last_name" value="{{ $contact->last_name }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Postion</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="position" value="{{ $contact->position }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Company</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="company" value="{{ $contact->company }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Fouuntain</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="fountain" value="{{ $contact->fountain }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Number</label>
                        <input type="number" class="form-control" id="exampleInputPassword1" name="number" value="{{ $contact->number }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="exampleInputPassword1" name="email" value="{{ $contact->email }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Twitter</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="twitter" value="{{ $contact->twitter }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Linkedin</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="linkedin" value="{{ $contact->linkedin }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Skype</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="skype" value="{{ $contact->skype }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Website</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="website" value="{{ $contact->website }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Address</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="address" value="{{ $contact->address }}">
                    </div>
                    <div class="mb-3"> <label for="exampleInputPassword1" class="form-label">Description</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="description" value="{{ $contact->description }}">
                    </div>

                </div> <!--end::Body--> <!--begin::Footer-->
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection