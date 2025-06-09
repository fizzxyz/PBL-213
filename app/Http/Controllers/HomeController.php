<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Galeri;
use App\Models\Artikel;
use App\Models\Company;
use App\Models\Yayasan;
use App\Models\Calendar;
use App\Models\Category;
use App\Models\HomeContent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UnitPendidikan;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $yayasan = Yayasan::where('id', 1)->first();
        $homeContent = HomeContent::where('id', 1)->first();
        $units = UnitPendidikan::all();
        $galeris = Galeri::latest()->get();
        $artikels = Artikel::all();
        $categories = Category::all();
        $videos = Video::with('unitPendidikan')
            ->orderBy('created_at', 'desc')
            ->get();
        $pengumuman = Artikel::with('category')
            ->whereHas('category', function ($query) {
                $query->where('name', 'Pengumuman');
            })
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        $calendars = Calendar::with('unitPendidikan')->get();

        return view('dashboard', compact('yayasan', 'homeContent', 'units', 'galeris', 'artikels', 'categories', 'pengumuman', 'videos', 'calendars'));
    }

    public function getYayasan()
    {
        $yayasan = Yayasan::where('id', 1)->first();
        $homeContent = HomeContent::where('id', 1)->first();
        return view('yayasan', compact('yayasan', 'homeContent'));
    }

    /**
     * Update home content sections
     */
    public function update(Request $request)
    {
        try {
            // Get the home content record (assuming single record or modify as needed)
            $homeContent = HomeContent::first();

            if (!$homeContent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Home content not found'
                ], 404);
            }

            // Define validation rules for different sections
            $rules = $this->getValidationRules($request);

            // Validate the request
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the content based on what fields are present
            $this->updateHeroContent($request, $homeContent);
            $this->updateCardContent($request, $homeContent);
            $this->updatePengantarContent($request, $homeContent);
            $this->updateGaleriContent($request, $homeContent);
            $this->updateVideoContent($request, $homeContent);

            // Save the updated content
            $homeContent->save();

            return response()->json([
                'success' => true,
                'message' => 'Content updated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('HomeContent update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get validation rules based on request content
     */
    private function getValidationRules(Request $request)
    {
        $rules = [];

        // Hero section rules
        if ($request->has('hero_title')) {
            $rules['hero_title'] = 'required|string|max:255';
            $rules['hero_sm_title'] = 'required|string|max:255';
            $rules['hero_text'] = 'required|string|max:1000';
            $rules['hero_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        // Card section rules
        if ($request->has('card_title')) {
            $rules['card_title'] = 'required|string|max:255';
            $rules['card_text'] = 'required|string|max:1000';
        }

        // Pengantar section rules
        if ($request->has('pengantar_title')) {
            $rules['pengantar_title'] = 'required|string|max:255';
            $rules['pengantar_sm_title'] = 'required|string|max:255';
            $rules['pengantar_text'] = 'required|string';
            $rules['pengantar_sm_text1'] = 'required|string|max:255';
            $rules['pengantar_sm_text2'] = 'required|string|max:255';
            $rules['pengantar_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        // Galeri section rules
        if ($request->has('galeri_title')) {
            $rules['galeri_title'] = 'required|string|max:255';
            $rules['galeri_sm_title'] = 'required|string|max:255';
        }

        // Video section rules
        if ($request->has('video_title')) {
            $rules['video_title'] = 'required|string|max:255';
            $rules['video_sm_title'] = 'required|string|max:255';
        }

        return $rules;
    }

    /**
     * Update hero section content
     */
    private function updateHeroContent(Request $request, $homeContent)
    {
        if ($request->has('hero_title')) {
            $homeContent->hero_title = $request->hero_title;
            $homeContent->hero_sm_title = $request->hero_sm_title;
            $homeContent->hero_text = $request->hero_text;

            // Handle hero image upload
            if ($request->hasFile('hero_image')) {
                $heroImage = $this->handleImageUpload(
                    $request->file('hero_image'),
                    'home/hero',
                    $homeContent->hero_image
                );
                $homeContent->hero_image = $heroImage;
            }
        }
    }

    /**
     * Update card section content
     */
    private function updateCardContent(Request $request, $homeContent)
    {
        if ($request->has('card_title')) {
            $homeContent->card_title = $request->card_title;
            $homeContent->card_text = $request->card_text;
        }
    }

    /**
     * Update pengantar section content
     */
    private function updatePengantarContent(Request $request, $homeContent)
    {
        if ($request->has('pengantar_title')) {
            $homeContent->pengantar_title = $request->pengantar_title;
            $homeContent->pengantar_sm_title = $request->pengantar_sm_title;
            $homeContent->pengantar_text = $request->pengantar_text;
            $homeContent->pengantar_sm_text1 = $request->pengantar_sm_text1;
            $homeContent->pengantar_sm_text2 = $request->pengantar_sm_text2;

            // Handle pengantar image upload
            if ($request->hasFile('pengantar_image')) {
                $pengantarImage = $this->handleImageUpload(
                    $request->file('pengantar_image'),
                    'home/pengantar',
                    $homeContent->pengantar_image
                );
                $homeContent->pengantar_image = $pengantarImage;
            }
        }
    }

    /**
     * Update galeri section content
     */
    private function updateGaleriContent(Request $request, $homeContent)
    {
        if ($request->has('galeri_title')) {
            $homeContent->galeri_title = $request->galeri_title;
            $homeContent->galeri_sm_title = $request->galeri_sm_title;
        }
    }

    /**
     * Update video section content
     */
    private function updateVideoContent(Request $request, $homeContent)
    {
        if ($request->has('video_title')) {
            $homeContent->video_title = $request->video_title;
            $homeContent->video_sm_title = $request->video_sm_title;
        }
    }

    /**
     * Handle image upload with specific directory structure
     */
    private function handleImageUpload($file, $directory, $oldImagePath = null)
    {
        try {
            // Delete old image if exists
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Store the file in the specified directory
            $path = $file->storeAs($directory, $filename, 'public');

            \Log::info("Image uploaded successfully to: " . $path);

            return $path;

        } catch (\Exception $e) {
            \Log::error("Image upload failed: " . $e->getMessage());
            throw new \Exception("Failed to upload image: " . $e->getMessage());
        }
    }

    /**
     * Get current home content for editing
     */
    public function getContent()
    {
        try {
            $homeContent = HomeContent::first();

            if (!$homeContent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Home content not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $homeContent
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle edit mode (optional - if you want to track edit mode state)
     */
    public function toggleEditMode(Request $request)
    {
        try {
            $isEditMode = $request->input('edit_mode', false);

            // You can store this in session or user preferences
            session(['edit_mode' => $isEditMode]);

            return response()->json([
                'success' => true,
                'edit_mode' => $isEditMode,
                'message' => $isEditMode ? 'Edit mode enabled' : 'Edit mode disabled'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle edit mode',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validate image file before upload
     */
    private function validateImageFile($file)
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        $maxSize = 2048 * 1024; // 2MB in bytes

        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception('Invalid file type. Only JPEG, PNG, JPG, and GIF are allowed.');
        }

        if ($file->getSize() > $maxSize) {
            throw new \Exception('File size too large. Maximum size is 2MB.');
        }

        return true;
    }

    public function updateYayasan(Request $request)
    {
        $request->validate([
            'section' => 'required|in:sejarah,vision,tentang',
            'content' => 'required|string',
        ]);

        $cleanContent = Purifier::clean($request->content);

        $yayasan = Yayasan::first();

        if (!$yayasan) {
            return response()->json([
                'success' => false,
                'message' => 'Data yayasan tidak ditemukan.'
            ], 404);
        }

        $yayasan->{$request->section} = $cleanContent;
        $yayasan->save();

        return response()->json([
            'success' => true,
            'updated_html' => $cleanContent,
        ]);
    }
}