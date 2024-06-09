@extends('admin.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="w-100 d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="{{ route('admin.contacts.create') }}">New</a>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Last Name </th>
                        <th>Postion</th>
                        <th>Company</th>
                        <th>Fouuntain</th>
                        <th>Number</th>
                        <th>Email Address</th>
                        <th>Twitter</th>
                        <th>Linkedin</th>
                        <th>Skype</th>
                        <th>Website</th>
                        <th>Address</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->last_name }}</td>
                            <td>{{ $contact->position }}</td>
                            <td>{{ $contact->company }}</td>
                            <td>{{ $contact->fountain }}</td>
                            <td>{{ $contact->number }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->twitter }}</td>
                            <td>{{ $contact->linkedin }}</td>
                            <td>{{ $contact->skype }}</td>
                            <td>{{ $contact->website }}</td>
                            <td>{{ $contact->address }}</td>
                            <td>{{ $contact->description }}</td>
                            <td class="d-flex" style="grid-gap: 10px;">
                                <a class="btn btn-success ml-2"  href="{{ route('admin.contacts.edit', $contact->id) }}">Edit</a>
                                <a class="btn btn-success"  href="{{ route('admin.contacts.delete',$contact->id) }}">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection