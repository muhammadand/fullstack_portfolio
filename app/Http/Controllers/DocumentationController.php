<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentation = Documentation::all();
        return view('documentation.index', compact('documentation'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documentation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'images' => 'nullable|image|max:10048',
        ]);

        $title = $request->title;
        $slug = Str::slug($request->title);
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
        }
        Documentation::create([
            'title' => $title,
            'images' => $fileName,
            'slug' => $slug,
        ]);

        return redirect()->route('documentation.index')->with('success', 'Documentation created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $documentation = Documentation::where('slug', $slug)->first();
        if (!$documentation) {
            return redirect()->route('documentation.index')->with('error', 'Documentation not found');
        }
        return view('documentation.show', compact('documentation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $documentation = Documentation::where('slug', $slug)->first();
        if (!$documentation) {
            return redirect()->route('documentation.index')->with('error', 'Documentation not found');
        }
        return view('documentation.edit', compact('documentation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $documentation = Documentation::where('slug', $slug)->first();
        if (!$documentation) {
            return redirect()->route('documentation.index')->with('error', 'Documentation not found');
        }
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
        }
        $documentation->update([
            'title' => $request->title,
            'images' => $fileName,
        ]);
        return redirect()->route('documentation.index')->with('success', 'Documentation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $documentation = Documentation::where('slug', $slug)->first();
        if (!$documentation) {
            return redirect()->route('documentation.index')->with('error', 'Documentation not found');
        }
        $documentation->delete();
        return redirect()->route('documentation.index')->with('success', 'Documentation deleted successfully');
    }
}
