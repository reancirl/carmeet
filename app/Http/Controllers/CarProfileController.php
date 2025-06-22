<?php

namespace App\Http\Controllers;

use App\Models\CarProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CarProfileController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->hasRole('registrant')) {
                abort(403, 'Unauthorized action. Only registrants can access this page.');
            }
            return $next($request);
        });
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carProfiles = Auth::user()->carProfiles()->latest()->get();
        return view('car-profiles.index', compact('carProfiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car-profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'trim' => 'nullable|string|max:255',
            'color' => 'required|string|max:255',
            'mods' => 'nullable|string',
            'plate' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'mod_tags' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
        
        $imageUrls = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('car-profiles', 'public');
                $imageUrls[] = asset('storage/' . $path);
            }
        }
        
        $carProfile = Auth::user()->carProfiles()->create([
            'make' => $validated['make'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'trim' => $validated['trim'] ?? null,
            'color' => $validated['color'],
            'mods' => $validated['mods'] ?? null,
            'plate' => $validated['plate'] ?? null,
            'description' => $validated['description'] ?? null,
            'facebook' => $validated['facebook'],
            'instagram' => $validated['instagram'],
            'tiktok' => $validated['tiktok'] ?? null,
            'twitter' => $validated['x'] ?? null,
            'mod_tags' => $validated['mod_tags'] ?? null,
            'image_urls' => $imageUrls,
        ]);
        
        return redirect()->route('car-profiles.index')
            ->with('success', 'Car profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carProfile = CarProfile::findOrFail($id);
        
        // Check if the car profile belongs to the authenticated user
        if ($carProfile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('car-profiles.show', compact('carProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $carProfile = CarProfile::findOrFail($id);
        
        // Check if the car profile belongs to the authenticated user
        if ($carProfile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('car-profiles.edit', compact('carProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $carProfile = CarProfile::findOrFail($id);
       
        // Check if the car profile belongs to the authenticated user
        if ($carProfile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'trim' => 'nullable|string|max:255',
            'color' => 'required|string|max:255',
            'mods' => 'nullable|string',
            'plate' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'mod_tags' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images' => 'nullable|array',
        ]);
        
        $imageUrls = $carProfile->image_urls ?? [];
        
        // Remove images if requested
        if ($request->has('remove_images') && is_array($request->remove_images)) {
            foreach ($request->remove_images as $index) {
                if (isset($imageUrls[$index])) {
                    // Extract the path from the URL and remove the file
                    $path = str_replace(asset('storage/'), '', $imageUrls[$index]);
                    Storage::disk('public')->delete($path);
                    unset($imageUrls[$index]);
                }
            }
            // Reindex the array
            $imageUrls = array_values($imageUrls);
        }
        
        // Add new images if uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('car-profiles', 'public');
                $imageUrls[] = asset('storage/' . $path);
            }
        }
        
        $carProfile->update([
            'make' => $validated['make'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'trim' => $validated['trim'] ?? null,
            'color' => $validated['color'],
            'mods' => $validated['mods'] ?? null,
            'plate' => $validated['plate'] ?? null,
            'description' => $validated['description'] ?? null,
            'facebook' => $validated['facebook'],
            'instagram' => $validated['instagram'],
            'tiktok' => $validated['tiktok'] ?? null,
            'twitter' => $validated['x'] ?? null,
            'mod_tags' => $validated['mod_tags'] ?? null,
            'image_urls' => $imageUrls,
        ]);
        
        return redirect()->route('car-profiles.index')
            ->with('success', 'Car profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carProfile = CarProfile::findOrFail($id);
        
        // Check if the car profile belongs to the authenticated user
        if ($carProfile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete associated images from storage
        if (!empty($carProfile->image_urls) && is_array($carProfile->image_urls)) {
            foreach ($carProfile->image_urls as $imageUrl) {
                $path = str_replace(asset('storage/'), '', $imageUrl);
                Storage::disk('public')->delete($path);
            }
        }
        
        $carProfile->delete();
        
        return redirect()->route('car-profiles.index')
            ->with('success', 'Car profile deleted successfully.');
    }
}