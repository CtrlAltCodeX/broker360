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
                    <div class="card-body">

                        <!-- New Fields -->
                        <div class="mb-3">
                            <label for="exampleInputOperationType" class="form-label required">Property Type</label>
                            <select class="form-control" name="property_type_id">
                                <option value="">--Select--</option>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('property_type_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputType" class="form-label required">Type</label>
                            <input type="text" class="form-control" id="exampleInputType" name="type" value="{{ old('type') }}">
                            @error('type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputAdType" class="form-label required">Ad Type</label>
                            <input type="text" class="form-control" id="exampleInputAdType" name="ad_type" value="{{ old('ad_type') }}">
                            @error('ad_type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputAdDesc" class="form-label required">Ad Description</label>
                            <label for="exampleInputAdDesc" class="form-label required">Ad Description</label>
                            <input type="text" class="form-control" id="exampleInputAdDesc" name="ad_desc">
                            @error('ad_desc')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputOperationType" class="form-label required">Operation Type</label>
                            <select class="form-control" name="operation_type">
                                <option value="">--Select--</option>
                                <option value="Sale" {{ old('operation_type') == 'Sale' ? 'selected' : '' }}>Sale</option>
                                <option value="Rent" {{ old('operation_type') == 'Rent' ? 'selected' : '' }}>Rent</option>
                                <option value="Temporary Rent" {{ old('operation_type') == 'Temporary Rent' ? 'selected' : '' }}>Temporary Rent</option>
                            </select>
                            @error('operation_type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputShowPriceAd" class="form-label required">Show Price Ad</label>
                            <input type="checkbox" id="exampleInputShowPriceAd" name="show_price_ad" {{ old('show_price_ad') ? 'checked' : '' }}>
                            @error('show_price_ad')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputBedroom" class="form-label required">Price</label>
                            <input type="number" class="form-control" id="exampleInputBedroom" name="price" value="{{ old('price') }}">
                            @error('price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputBathrooms" class="form-label">Bathrooms</label>
                            <input type="number" class="form-control" id="exampleInputBathrooms" name="bathrooms" value="{{ old('bathrooms') }}">
                            @error('bathrooms')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputHalfBath" class="form-label">Half Bath</label>
                            <input type="number" class="form-control" id="exampleInputHalfBath" name="half_bath" value="{{ old('half_bath') }}">
                            @error('half_bath')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputParkingLots" class="form-label">Parking Lots</label>
                            <input type="number" class="form-control" id="exampleInputParkingLots" name="parking_lots" value="{{ old('parking_lots') }}">
                            @error('parking_lots')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputConstruction" class="form-label required">Construction (sqm)</label>
                            <input type="number" class="form-control" id="exampleInputConstruction" name="construction" value="{{ old('construction') }}">
                            @error('construction')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputYearConstruction" class="form-label">Year of Construction</label>
                            <input type="number" class="form-control" id="exampleInputYearConstruction" name="year_construction" value="{{ old('year_construction') }}">
                            @error('year_construction')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputNumberPlants" class="form-label required">Number of Plants</label>
                            <input type="number" class="form-control" id="exampleInputNumberPlants" name="number_plants" value="{{ old('number_plants') }}">
                            @error('number_plants')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputNumberFloors" class="form-label">Number of Floors</label>
                            <input type="number" class="form-control" id="exampleInputNumberFloors" name="number_floors" value="{{ old('number_floors') }}">
                            @error('number_floors')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputMonthlyMaintenance" class="form-label">Monthly Maintenance</label>
                            <input type="number" class="form-control" id="exampleInputMonthlyMaintenance" name="monthly_maintenance" value="{{ old('monthly_maintenance') }}">
                            @error('monthly_maintenance')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputInternalKey" class="form-label">Internal Key</label>
                            <input type="text" class="form-control" id="exampleInputInternalKey" name="internal_key" value="{{ old('internal_key') }}">
                            @error('internal_key')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputKeyCode" class="form-label">Key Code</label>
                            <input type="text" class="form-control" id="exampleInputKeyCode" name="key_code" value="{{ old('key_code') }}">
                            @error('key_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputStreet" class="form-label">Street</label>
                            <input type="text" class="form-control" id="exampleInputStreet" name="street" value="{{ old('street') }}">
                            @error('street')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputCornerWith" class="form-label">Corner With</label>
                            <input type="text" class="form-control" id="exampleInputCornerWith" name="corner_with" value="{{ old('corner_with') }}">
                            @error('corner_with')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPostalCode" class="form-label">Postal Code</label>
                            <input type="number" class="form-control" id="exampleInputPostalCode" name="postal_code" value="{{ old('postal_code') }}">
                            @error('postal_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputShareCommission" class="form-label">Share Commission</label><br>
                            <input type="radio" name="share_commission" value="1" {{ old('share_commission') == '1' ? 'checked' : '' }} /><span style="margin-left: 10px;">Yes</span><br>
                            <input type="radio" name="share_commission" value="0" {{ old('share_commission') == '0' ? 'checked' : '' }} /><span style="margin-left: 10px;">No</span>
                            @error('share_commission')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputCommissionPercent" class="form-label">Commission Percent</label>
                            <input type="number" class="form-control" id="exampleInputCommissionPercent" name="commission_percent" value="{{ old('commission_percent') }}">
                            @error('commission_percent')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputConditionSharing" class="form-label">Condition Sharing</label>
                            <input type="text" class="form-control" id="exampleInputConditionSharing" name="condition_sharing">
                            @error('condition_sharing')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Amenities</label>
                            <select class="form-control" multiple name="property_features[]">
                                <option value="">--Select--</option>
                                <option value="Muelle de carga">Muelle de carga</option>
                                <option value="Acceso a la playa">Acceso a la playa</option>
                                <option value="Andén">Andén</option>
                                <option value="Balcón">Balcón</option>
                                <option value="Cisterna">Cisterna</option>
                                <option value="Frente a la playa">Frente a la playa</option>
                                <option value="Garaje">Garaje</option>
                                <option value="Jardín">Jardín</option>
                                <option value="Parrilla">Parrilla</option>
                                <option value="Patio">Patio</option>
                                <option value="Riego por aspersión">Riego por aspersión</option>
                                <option value="Roof of garden">Roof of garden</option>
                                <option value="Terraza">Terraza</option>
                                <option value="Vista al mar">Vista al mar</option>
                                <option value="Accesibilidad para personas con discapacidad">Accesibilidad para personas con discapacidad</option>
                                <option value="Aire acondicionado">Aire acondicionado</option>
                                <option value="Alarma">Alarma</option>
                                <option value="Amueblado">Amueblado</option>
                                <option value="Bodega">Bodega</option>
                                <option value="Calefacción">Calefacción</option>
                                <option value="Chimenea">Chimenea</option>
                                <option value="Circuito cerrado">Circuito cerrado</option>
                                <option value="Cocina integral">Cocina integral</option>
                                <option value="Conmutador">Conmutador</option>
                                <option value="Cuarto de servicio">Cuarto de servicio</option>
                                <option value="Elevador">Elevador</option>
                                <option value="Fraccionamiento privado">Fraccionamiento </option>
                                <option value="Hidroneumático">Hidroneumático</option>
                                <option value="Mascotas permitidas">Mascotas permitidas</option>
                                <option value="Panel solar">Panel solar</option>
                                <option value="Penthouse">Penthouse</option>
                                <option value="Generador eléctrico">Generador eléctrico</option>
                                <option value="Portero">Portero</option>
                                <option value="Recámaras en planta baja">Recámaras en planta baja</option>
                                <option value="Seguridad">Seguridad</option>
                                <option value="Alberca">Alberca</option>
                                <option value="Área de juegos infantiles">Área de juegos infantiles</option>
                                <option value="Cancha de padel">Cancha de padel</option>
                                <option value="Cancha de tenis">Cancha de tenis</option>
                                <option value="Fogatero">Fogatero</option>
                                <option value="Gimnasio">Gimnasio</option>
                                <option value="Jacuzzi">Jacuzzi</option>
                                <option value="Salón de usos múltiples">Salón de usos múltiples</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputConditionSharing" class="form-label">Images</label>
                            <input type="file" multiple class="form-control" name="property_image[]">
                            @error('condition_sharing')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Users</label>
                            <select class="form-control required" name="user_id">
                                <option value="">--Select--</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button> </div> <!--end::Footer-->
            </form> <!--end::Form-->
        </div>
    </div>
</div>
@endsection