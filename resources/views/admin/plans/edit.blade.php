@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form action="{{ route('admin.plans.update', $plans->id) }}" method="post" enctype="multipart/form-data"> <!--begin::Body-->
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $plans->name) }}">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Desc ( Type features Comma Seprated )</label>
                        <textarea class="form-control" id="desc" name="desc">{{ old('desc', $plans->desc) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $plans->price) }}" step="0.01">
                    </div>
                    
                </div> <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection