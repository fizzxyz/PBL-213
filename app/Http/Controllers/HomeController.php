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
use Illuminate\Http\Request;
use App\Models\UnitPendidikan;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;

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
            ->take(8) // atau sesuai kebutuhan
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

    public function updateContent(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'hero_title' => 'nullable|string|max:255',
                'hero_text' => 'nullable|string',
                'hero_sm_title' => 'nullable|string|max:255',
                'hero_image' => 'nullable|string|max:500',
                'card_title' => 'nullable|string|max:255',
                'card_text' => 'nullable|string',
                'galeri_title' => 'nullable|string|max:255',
                'galeri_sm_title' => 'nullable|string|max:255',
                'video_title' => 'nullable|string|max:255',
                'video_sm_title' => 'nullable|string|max:255',
                'pengantar_title' => 'nullable|string',
                'pengantar_sm_title' => 'nullable|string|max:255',
                'pengantar_text' => 'nullable|string',
                'pengantar_image' => 'nullable|string|max:500',
                'pengantar_sm_text1' => 'nullable|string|max:255',
                'pengantar_sm_text2' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $homeContent = HomeContent::first();

            if (!$homeContent) {
                $homeContent = new HomeContent();
                $homeContent->hero_title = $request->hero_title ?? 'Default Hero Title';
                $homeContent->hero_text = Purifier::clean($request->hero_text ?? 'Default Hero Text');
                $homeContent->hero_sm_title = $request->hero_sm_title ?? 'Default Small Title';
                $homeContent->card_title = $request->card_title ?? 'Default Card Title';
                $homeContent->card_text = Purifier::clean($request->card_text ?? 'Default Card Text');
                $homeContent->galeri_title = $request->galeri_title ?? 'Default Galeri Title';
                $homeContent->galeri_sm_title = $request->galeri_sm_title ?? 'Default Galeri Small Title';
                $homeContent->video_title = $request->video_title ?? 'Default Video Title';
                $homeContent->video_sm_title = $request->video_sm_title ?? 'Default Video Small Title';
                $homeContent->pengantar_title = $request->pengantar_title ?? 'Default Pengantar Title';
                $homeContent->pengantar_sm_title = $request->pengantar_sm_title ?? 'Default Pengantar Small Title';
                $homeContent->pengantar_text = Purifier::clean($request->pengantar_text ?? 'Default Pengantar Text');
                $homeContent->pengantar_sm_text1 = $request->pengantar_sm_text1 ?? 'Default Name';
                $homeContent->pengantar_sm_text2 = $request->pengantar_sm_text2 ?? 'Default Position';
            } else {
                $fillableFields = [
                    'hero_title', 'hero_text', 'hero_sm_title', 'hero_image',
                    'card_title', 'card_text',
                    'galeri_title', 'galeri_sm_title',
                    'video_title', 'video_sm_title',
                    'pengantar_title', 'pengantar_sm_title', 'pengantar_text',
                    'pengantar_image', 'pengantar_sm_text1', 'pengantar_sm_text2'
                ];

                $sanitizeFields = ['pengantar_text'];

                foreach ($fillableFields as $field) {
                    if ($request->has($field)) {
                        $value = $request->$field;
                        $homeContent->$field = in_array($field, $sanitizeFields)
                            ? Purifier::clean($value)
                            : $value;
                    }
                }
            }

            $homeContent->save();

            return response()->json([
                'success' => true,
                'message' => 'Content updated successfully',
                'data' => $homeContent
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
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
