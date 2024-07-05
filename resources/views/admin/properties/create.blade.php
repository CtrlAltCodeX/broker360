@extends('admin.app')

@section('content')
<style>
    .required::after {
        content: " *";
        color: red;
    }
</style>

<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <form action="{{ route('admin.properties.store') }}" method="post" enctype="multipart/form-data"> <!--begin::Body-->
                @csrf
                <div class="card-body">
                    <!-- New Fields -->
                    <div class="mb-3">
                        <label for="exampleInputType" class="form-label required">Type</label>
                        <input type="text" class="form-control" required id="exampleInputType" name="type">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputAdType" class="form-label required">Ad Type</label>
                        <input type="text" class="form-control" required id="exampleInputAdType" name="ad_type">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputAdDesc" class="form-label required">Ad Description</label>
                        <input type="text" class="form-control" required id="exampleInputAdDesc" name="ad_desc">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputOperationType" class="form-label required">Operation Type</label>
                        <input type="text" class="form-control" required id="exampleInputOperationType" name="operation_type">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputShowPriceAd" class="form-label required">Show Price Ad</label>
                        <input type="checkbox" id="exampleInputShowPriceAd" required name="show_price_ad">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputBedroom" class="form-label required">Price</label>
                        <input type="number" class="form-control" id="exampleInputBedroom" required name="price">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputBathrooms" class="form-label">Bathrooms</label>
                        <input type="number" class="form-control" id="exampleInputBathrooms" name="bathrooms">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputHalfBath" class="form-label">Half Bath</label>
                        <input type="number" class="form-control" id="exampleInputHalfBath" name="half_bath">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputParkingLots" class="form-label">Parking Lots</label>
                        <input type="number" class="form-control" id="exampleInputParkingLots" name="parking_lots">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputConstruction" class="form-label required">Construction (sqm)</label>
                        <input type="number" class="form-control" required id="exampleInputConstruction" name="construction">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputYearConstruction" class="form-label">Year of Construction</label>
                        <input type="number" class="form-control" id="exampleInputYearConstruction" name="year_construction">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputNumberPlants" class="form-label required">Number of Plants</label>
                        <input type="number" class="form-control" id="exampleInputNumberPlants" required name="number_plants">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputNumberFloors" class="form-label">Number of Floors</label>
                        <input type="number" class="form-control" id="exampleInputNumberFloors" name="number_floors">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputMonthlyMaintenance" class="form-label">Monthly Maintenance</label>
                        <input type="number" class="form-control" id="exampleInputMonthlyMaintenance" name="monthly_maintenance">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputInternalKey" class="form-label">Internal Key</label>
                        <input type="text" class="form-control" id="exampleInputInternalKey" name="internal_key">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputKeyCode" class="form-label">Key Code</label>
                        <input type="text" class="form-control" id="exampleInputKeyCode" name="key_code">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputStreet" class="form-label">Street</label>
                        <input type="number" class="form-control" id="exampleInputStreet" name="street">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputCornerWith" class="form-label">Corner With</label>
                        <input type="number" class="form-control" id="exampleInputCornerWith" name="corner_with">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPostalCode" class="form-label">Postal Code</label>
                        <input type="number" class="form-control" id="exampleInputPostalCode" name="postal_code">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPropertyFeatures" class="form-label">Property Features</label>
                        <input type="text" class="form-control" id="exampleInputPropertyFeatures" name="property_features">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputShareCommission" class="form-label">Share Commission</label>
                        <input type="number" class="form-control" id="exampleInputShareCommission" name="share_commission">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputCommissionPercent" class="form-label">Commission Percent</label>
                        <input type="number" class="form-control" id="exampleInputCommissionPercent" name="commission_percent">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputConditionSharing" class="form-label">Condition Sharing</label>
                        <input type="text" class="form-control" id="exampleInputConditionSharing" name="condition_sharing">
                    </div>
                    <div class="mb-3">
                        <label>Users</label>
                        <select class="form-control required" name="user_id" required>
                            <option value="">--Select--</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection