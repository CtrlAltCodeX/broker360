@extends('admin.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="w-100 d-flex justify-content-end mb-4">
                <a class="btn btn-primary" href="{{ route('help_tutorial.create') }}">New</a>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($helps as $help)
                    <tr>
                        <td>{{ $help->title }}</td>
                        <td>{{ $help->link }}</td>
                        <td class="d-flex" style="grid-gap: 10px;">
                            <a class="btn btn-success ml-2" href="{{ route('help_tutorial.edit', $help->id) }}">Edit</a>
                            <form action="{{ route('help_tutorial.destroy',$help->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-success">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection