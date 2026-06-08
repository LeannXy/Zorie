<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryBanner;
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

    public function store(Request $request)
    {
        $request->validate([

            'category_id' => 'required',
            'title' => 'required',

            'subtitle' => 'nullable',

            'button_text' => 'nullable',

            'image' => 'nullable|image',

            'banner_type' =>
            'required|in:main,secondary',



        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request
                ->file('image')
                ->store(
                    'category-banners',
                    'public'
                );
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
        CategoryBanner $categoryBanner
    ) {
        $request->validate([

            'category_id' => 'required',

            'title' => 'required',

            'subtitle' => 'nullable',

            'button_text' => 'nullable',

            'image' => 'nullable|image',

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

        if ($request->hasFile('image')) {

            $data['image'] =
                $request
                ->file('image')
                ->store(
                    'category-banners',
                    'public'
                );
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
        CategoryBanner $categoryBanner
    ) {
        $categoryBanner->delete();

        return back()
            ->with(
                'success',
                'Banner deleted'
            );
    }
}
