@extends('admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center my-3">
        <div class="col-md-6">
            <form action="{{ route('admin.features.update', $propertyFeatures->id) }}" method="post"> <!--begin::Body-->
                @csrf
                <div class="card-body">
                    <div class="mb-3"> <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $propertyFeatures->name }}" name="name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Category</label>
                        <select class="form-control" name="category">
                            <option value="">--Select--</option>
                            <option {{ $propertyFeatures->category == 'Amenidades' ? 'selected' : '' }} value="Amenidades">Amenidades</option>
                            <option {{ $propertyFeatures->category == 'Exterior' ? 'selected' : '' }} value="Exterior">Exterior</option>
                            <option {{ $propertyFeatures->category == 'General' ? 'selected' : '' }} value="General">General</option>
                            <option {{ $propertyFeatures->category == 'Políticas' ? 'selected' : '' }} value="Políticas">Políticas</option>
                            <option {{ $propertyFeatures->category == 'Recreación' ? 'selected' : '' }} value="Recreación">Recreación</option>
                        </select>
                        @error('category')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div> <!--end::Body--> <!--begin::Footer-->
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection