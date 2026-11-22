<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryBanner;
use App\Services\CloudinaryImageStorage;
use Illuminate\Http\Request;

class CategoryBannerController extends Controller
{
    public function index()
    {
        $banners = CategoryBanner::with(
            'category'
        )
            ->latest()
            ->paginate(10);

        return view(
            'pages.category-banners.index',
            compact('banners')
        );
    }

    public function create()
    {
        $categories = Category::where(
            'status',
            true
        )->get();

        return view(
            'pages.category-banners.create',
            compact('categories')
        );
    }

    public function store(Request $request, CloudinaryImageStorage $imageStorage)
    {
        $request->validate([

            'category_id' => 'required',
            'title' => 'required',

            'subtitle' => 'nullable',

            'button_text' => 'nullable',

            'image' => $request->hasFile('image')
                ? 'nullable|image'
                : 'nullable|string|max:255',

            'banner_type' =>
            'required|in:main,secondary',



        ]);

        if ($request->banner_type === 'main') {

            $existingMain = CategoryBanner::where(
                'category_id',
                $request->category_id
            )
                ->where(
                    'banner_type',
                    'main'
                )
                ->exists();

            if ($existingMain) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'banner_type' =>
                        'This category already has a Main Banner.'
                    ]);
            }
        }

        if ($request->banner_type === 'secondary') {

            $secondaryCount = CategoryBanner::where(
                'category_id',
                $request->category_id
            )
                ->where(
                    'banner_type',
                    'secondary'
                )
                ->count();

            if ($secondaryCount >= 2) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'banner_type' =>
                        'Maximum 2 Secondary Banners per category.'
                    ]);
            }
        }

        $image = $imageStorage->storeRequestImage($request, 'image', 'category-banners');

        CategoryBanner::create([

            'category_id' => $request->category_id,

            'title' => $request->title,

            'subtitle' => $request->subtitle,

            'button_text' => $request->button_text,

            'image' => $image,

            'status' => true,

            'banner_type' =>
            $request->banner_type,

        ]);

        return redirect()
            ->route(
                'category-banners.index'
            )
            ->with(
                'success',
                'Banner created successfully'
            );
    }

    public function edit(
        CategoryBanner $categoryBanner
    ) {
        $categories = Category::all();

        $banner = $categoryBanner;

        return view(
            'pages.category-banners.edit',
            compact(
                'banner',
                'categories'
            )
        );
    }


    public function update(
        Request $request,
        CategoryBanner $categoryBanner,
        CloudinaryImageStorage $imageStorage
    ) {
        $request->validate([

            'category_id' => 'required',

            'title' => 'required',

            'subtitle' => 'nullable',

            'button_text' => 'nullable',

            'image' => $request->hasFile('image')
                ? 'nullable|image'
                : 'nullable|string|max:255',

            'banner_type' =>
            'required|in:main,secondary',

        ]);

        $data = [

            'category_id' => $request->category_id,

            'title' => $request->title,

            'subtitle' => $request->subtitle,

            'button_text' => $request->button_text,

            'status' => $request->has('status'),

            'banner_type' =>
            $request->banner_type,

        ];

        $previousImage = null;
        if ($request->hasFile('image') || $request->filled('image')) {
            $previousImage = $categoryBanner->image;
            $data['image'] = $imageStorage->storeRequestImage($request, 'image', 'category-banners');
        }
        if ($request->banner_type === 'main') {

            $existingMain = CategoryBanner::where(
                'category_id',
                $request->category_id
            )
                ->where(
                    'banner_type',
                    'main'
                )
                ->where(
                    'id',
                    '!=',
                    $categoryBanner->id
                )
                ->exists();

            if ($existingMain) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'banner_type' =>
                        'This category already has a Main Banner.'
                    ]);
            }
        }

        if ($request->banner_type === 'secondary') {

            $secondaryCount = CategoryBanner::where(
                'category_id',
                $request->category_id
            )
                ->where(
                    'banner_type',
                    'secondary'
                )
                ->where(
                    'id',
                    '!=',
                    $categoryBanner->id
                )
                ->count();

            if ($secondaryCount >= 2) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'banner_type' =>
                        'Maximum 2 Secondary Banners per category.'
                    ]);
            }
        }
        
        $categoryBanner->update(
            $data
        );

        if ($previousImage) {
            $imageStorage->delete($previousImage);
        }

        return redirect()
            ->route(
                'category-banners.index'
            )
            ->with(
                'success',
                'Banner updated'
            );
    }


    public function destroy(
        CategoryBanner $categoryBanner,
        CloudinaryImageStorage $imageStorage
    ) {
        $imageStorage->delete($categoryBanner->image);
        $categoryBanner->delete();

        return back()
            ->with(
                'success',
                'Banner deleted'
            );
    }
}
