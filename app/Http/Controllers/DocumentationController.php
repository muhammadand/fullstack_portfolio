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
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        $documentation = Documentation::when($search !== '', function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%");
        })
        ->latest('id')
        ->paginate(15)
        ->withQueryString();

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
            'title' => 'required|string|max:200',
            'images' => 'nullable|image|max:10048',
        ]);

        $title = $request->title;
        $slug = Str::slug($request->title) . '-' . uniqid();
        $fileName = null;

        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
        }

        Documentation::create([
            'title' => $title,
            'images' => $fileName,
            'slug' => $slug,
        ]);

        return redirect()->route('documentation.index')->with('success', 'Dokumentasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $documentation = Documentation::where('slug', $slug)->first();
        if (!$documentation) {
            return redirect()->route('documentation.index')->with('error', 'Dokumentasi tidak ditemukan');
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
            return redirect()->route('documentation.index')->with('error', 'Dokumentasi tidak ditemukan');
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
            return redirect()->route('documentation.index')->with('error', 'Dokumentasi tidak ditemukan');
        }

        $request->validate([
            'title' => 'required|string|max:200',
            'images' => 'nullable|image|max:10048',
        ]);

        $data = [
            'title' => $request->title,
        ];

        if ($request->boolean('remove_images')) {
            if ($documentation->images && file_exists(public_path('images/' . $documentation->images))) {
                @unlink(public_path('images/' . $documentation->images));
            }
            $data['images'] = null;
        } elseif ($request->hasFile('images')) {
            $file = $request->file('images');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);

            if ($documentation->images && file_exists(public_path('images/' . $documentation->images))) {
                @unlink(public_path('images/' . $documentation->images));
            }

            $data['images'] = $fileName;
        }

        $documentation->update($data);

        return redirect()->route('documentation.index')->with('success', 'Dokumentasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $documentation = Documentation::where('slug', $slug)->first();
        if (!$documentation) {
            return redirect()->route('documentation.index')->with('error', 'Dokumentasi tidak ditemukan');
        }

        // Hapus file fisik jika ada
        if ($documentation->images && file_exists(public_path('images/' . $documentation->images))) {
            @unlink(public_path('images/' . $documentation->images));
        }

        $documentation->delete();
        return redirect()->route('documentation.index')->with('success', 'Dokumentasi berhasil dihapus');
    }
}
