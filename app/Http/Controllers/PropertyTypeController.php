<?php

namespace App\Http\Controllers;

use App\Models\PropertyFeature;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = PropertyType::all();

        return view('admin.property-type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.property-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        PropertyType::create(request()->all());

        return redirect()->route('admin.type.index');
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
        $propertyTypes = PropertyType::find($id);

        return view('admin.property-type.edit', compact('propertyTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $propertyTypes = PropertyType::find($id);

        $propertyTypes->update(request()->all());

        return redirect()->route('admin.type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $propertyTypes = PropertyType::find($id);

        $propertyTypes->delete();

        return redirect()->route('admin.type.index');
    }
}
