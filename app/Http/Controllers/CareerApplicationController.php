<?php

namespace App\Http\Controllers;

use App\Models\CareerApplication;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Notifications\NewCareerApplicationNotification;
use Illuminate\Support\Facades\Notification;

class CareerApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CareerApplication::with('career')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('career', function($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
        }

        $applications = $query->paginate(10)->withQueryString();

        return view('career-applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = Career::where('is_active', true)->get();
        return view('career-applications.create', compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'career_id' => 'required|exists:careers,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'portfolio_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'cover_letter' => 'nullable|string',
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $validated['applied_at'] = now();

        $application = CareerApplication::create($validated);

        // Notify admins
        $admins = User::all();
        Notification::send($admins, new NewCareerApplicationNotification($application));

        return redirect()->back()->with('success', 'Lamaran berhasil disubmit.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CareerApplication $careerApplication)
    {
        return view('career-applications.show', compact('careerApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CareerApplication $careerApplication)
    {
        $careers = Career::where('is_active', true)->get();
        return view('career-applications.edit', compact('careerApplication', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CareerApplication $careerApplication)
    {
        $validated = $request->validate([
            'career_id' => 'required|exists:careers,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'portfolio_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'cover_letter' => 'nullable|string',
        ]);

        if ($request->hasFile('resume')) {
            // Hapus resume lama jika ada
            if ($careerApplication->resume) {
                Storage::disk('public')->delete($careerApplication->resume);
            }
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $careerApplication->update($validated);

        return redirect()->route('career-applications.index')->with('success', 'Lamaran berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CareerApplication $careerApplication)
    {
        if ($careerApplication->resume) {
            Storage::disk('public')->delete($careerApplication->resume);
        }
        
        $careerApplication->delete();

        return redirect()->route('career-applications.index')->with('success', 'Lamaran berhasil dihapus.');
    }
}
