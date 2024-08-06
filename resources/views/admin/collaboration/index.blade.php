@extends('admin.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="w-100 d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="{{ route('admin.collaboration.create') }}">New</a>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Agent Name </th>
                        <!-- <th>Number</th> -->
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($collaborations as $user)
                    <tr>
                        <td>{{ $user->user->name }}</td>
                        <td>{{ $user->agent->name }}</td>
                        <td class="d-flex" style="grid-gap: 10px;">
                            <a class="btn btn-success ml-2" href="{{ route('admin.collaboration.edit', $user->id) }}">Edit</a>
                            <a class="btn btn-success" href="{{ route('admin.collaboration.delete',$user->id) }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $collaborations->links() }}
        </div>
    </div>
</div>
@endsection