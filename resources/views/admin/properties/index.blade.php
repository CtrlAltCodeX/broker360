@extends('admin.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="w-100 d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="{{ route('admin.properties.create') }}">New</a>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Ad Type</th>
                        <th>Ad Description</th>
                        <th>Operation Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $property)
                    <tr>
                        <td>{{ $property->type }}</td>
                        <td>{{ $property->ad_type }}</td>
                        <td>{{ $property->ad_desc }}</td>
                        <td>{{ $property->operation_type }}</td>
                        <td class="d-flex" style="grid-gap: 10px;">
                            <a class="btn btn-success ml-2" href="{{ route('admin.properties.show', $property->id) }}">View</a>
                            <a class="btn btn-success ml-2" href="{{ route('admin.properties.edit', $property->id) }}">Edit</a>
                            <a class="btn btn-success" href="{{ route('admin.properties.delete',$property->id) }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection