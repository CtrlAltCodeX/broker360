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
                        <th>Show Price Ad</th>
                        <th>Bedroom</th>
                        <th>Bathrooms</th>
                        <th>Half Bath</th>
                        <th>Parking Lots</th>
                        <th>Construction</th>
                        <th>Year of Construction</th>
                        <th>Number of Plants</th>
                        <th>Number of Floors</th>
                        <th>Monthly Maintenance</th>
                        <th>Internal Key</th>
                        <th>Key Code</th>
                        <th>User ID</th>
                        <th>Street</th>
                        <th>Corner With</th>
                        <th>Postal Code</th>
                        <th>Property Features</th>
                        <th>Share Commission</th>
                        <th>Commission Percent</th>
                        <th>Condition Sharing</th>
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
                        <td>{{ $property->show_price_ad ? 'Yes' : 'No' }}</td>
                        <td>{{ $property->bedroom }}</td>
                        <td>{{ $property->bathrooms }}</td>
                        <td>{{ $property->half_bath }}</td>
                        <td>{{ $property->parking_lots }}</td>
                        <td>{{ $property->construction }}</td>
                        <td>{{ $property->year_construction }}</td>
                        <td>{{ $property->number_plants }}</td>
                        <td>{{ $property->number_floors }}</td>
                        <td>{{ $property->monthly_maintenance }}</td>
                        <td>{{ $property->internal_key }}</td>
                        <td>{{ $property->key_code }}</td>
                        <td>{{ $property->user_id }}</td>
                        <td>{{ $property->street }}</td>
                        <td>{{ $property->corner_with }}</td>
                        <td>{{ $property->postal_code }}</td>
                        <td>{{ $property->property_features }}</td>
                        <td>{{ $property->share_commission }}</td>
                        <td>{{ $property->commission_percent }}</td>
                        <td>{{ $property->condition_sharing }}</td>
                        <td class="d-flex" style="grid-gap: 10px;">
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