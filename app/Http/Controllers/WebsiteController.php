<?php

namespace App\Http\Controllers;

use App\Models\Website;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::all();

        return view('admin.website.index', compact('websites'));
    }

    public function edit($id)
    {
        $websites = Website::find($id);

        return view('admin.website.edit', compact('websites'));
    }

    public function update($id)
    {
        $websites = Website::query();

        $websites->update(request()->all(), $id);

        return redirect()->route('admin.website.index');
    }
}
