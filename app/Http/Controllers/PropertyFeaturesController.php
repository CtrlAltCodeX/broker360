<?php

namespace App\Http\Controllers;

use App\Models\PropertyFeature;
use Illuminate\Http\Request;

class PropertyFeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = PropertyFeature::all();

        return view('admin.property-features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.property-features.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PropertyFeature::create(request()->all());

        return redirect()->route('admin.features.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $propertyFeatures = PropertyFeature::find($id);

        return view('admin.property-features.edit', compact('propertyFeatures'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $propertyFeatures = PropertyFeature::find($id);
        
        $propertyFeatures->update(request()->all());

        return redirect()->route('admin.features.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $propertyFeatures = PropertyFeature::find($id);

        $propertyFeatures->delete();

        return redirect()->route('admin.features.index');
    }
}
