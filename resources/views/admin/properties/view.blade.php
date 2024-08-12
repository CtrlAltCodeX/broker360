@extends('admin.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end mb-4" style="grid-gap: 10px;">
                <a class="btn btn-primary" href="{{ route('admin.properties.index') }}">Back to List</a>
                <a class="btn btn-success ml-2" href="{{ route('admin.properties.edit', $property->id) }}">Edit</a>
                <form action="{{ route('admin.properties.delete', $property->id) }}" method="POST" class="ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>{{ ucwords($property->types->name) }} - {{ ucwords($property->ad_type) }}</h3>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><b>Ad Description</b></h5><br>
                    <p class="card-text">{{ ucwords($property->ad_desc) }}</p>
                    <div class="row">
                        <div class="col-md-4 d-flex flex-column">
                            <h5 class="card-title">Details</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Operation Type:</strong> {{ $property->operation_type }}</li>
                                <li class="list-group-item"><strong>Show Price Ad:</strong> {{ $property->show_price_ad ? 'Yes' : 'No' }}</li>
                                <li class="list-group-item"><strong>Bedroom:</strong> {{ $property->bedroom }}</li>
                                <li class="list-group-item"><strong>Bathrooms:</strong> {{ $property->bathrooms }}</li>
                                <li class="list-group-item"><strong>Half Bath:</strong> {{ $property->half_bath }}</li>
                                <li class="list-group-item"><strong>Parking Lots:</strong> {{ $property->parking_lots }}</li>
                                <li class="list-group-item"><strong>Construction:</strong> {{ $property->construction }}</li>
                                <li class="list-group-item"><strong>Year of Construction:</strong> {{ $property->year_construction }}</li>
                                <li class="list-group-item"><strong>Number of Plants:</strong> {{ $property->number_plants }}</li>
                                <li class="list-group-item"><strong>Number of Floors:</strong> {{ $property->number_floors }}</li>
                                <li class="list-group-item"><strong>Monthly Maintenance:</strong> {{ $property->monthly_maintenance }}</li>
                                <li class="list-group-item"><strong>Internal Key:</strong> {{ $property->internal_key }}</li>
                                <li class="list-group-item"><strong>Key Code:</strong> {{ $property->key_code }}</li>
                            </ul>
                        </div>
                        <div class="col-md-4 d-flex flex-column">
                            <h5 class="card-title">Location & Features</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>User:</strong> {{ $property->user->name }}</li>
                                <li class="list-group-item"><strong>Street:</strong> {{ $property->street }}</li>
                                <li class="list-group-item"><strong>Corner With:</strong> {{ $property->corner_with }}</li>
                                <li class="list-group-item"><strong>Postal Code:</strong> {{ $property->postal_code }}</li>
                                <li class="list-group-item"><strong>Share Commission:</strong> {{ $property->share_commission }}</li>
                                <li class="list-group-item"><strong>Commission Percent:</strong> {{ $property->commission_percent }}</li>
                                <li class="list-group-item"><strong>Condition Sharing:</strong> {{ $property->condition_sharing }}</li>
                            </ul>
                        </div>
                        <div class="col-md-4 d-flex flex-column">
                            <h5>Amenities</h5>
                            @php
                                $features = explode(',', $property->property_features)
                            @endphp
                            <ul>
                                @foreach($features as $feature)
                                <li>{{$feature}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection