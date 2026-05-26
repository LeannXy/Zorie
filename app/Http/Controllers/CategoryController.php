<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        $search = trim(
            $request->search
        );
        $categories = Category::withCount('products')

            ->when(
                $search,
                function ($query) use ($search) {

                    $query->where(
                        function ($q) use ($search) {

                            $q->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )

                                ->orWhere(
                                    'description',
                                    'like',
                                    "%{$search}%"
                                );
                        }

                    );
                }
            )

            ->when(
                $request->status !== null &&
                    $request->status !== '',

                fn($q) =>

                $q->where(
                    'status',
                    $request->status
                )

            )


            ->orderBy(

                request(
                    'sort',
                    'created_at'
                ),

                request(
                    'direction',
                    'desc'
                )

            )

            ->latest()

            ->paginate(10)

            ->withQueryString();

        $totalCategories = Category::count();

        $activeCategories = Category::where(
            'status',
            true
        )->count();

        $inactiveCategories = Category::where(
            'status',
            false
        )->count();

        $popularCategory = Category::withCount(
            'products'
        )
            ->orderByDesc(
                'products_count'
            )
            ->first();

        $categoryCollection =
            $categories->getCollection();

        $categoryChartLabels =
            $categoryCollection->pluck(
                'name'
            );

        $categoryChartData =
            $categoryCollection->pluck(
                'products_count'
            );

        return view(
            'pages.categories',
            compact(
                'categories',
                'totalCategories',
                'activeCategories',
                'inactiveCategories',
                'popularCategory',
                'categoryChartLabels',
                'categoryChartData',
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|unique:categories,name',

            'description' => 'required'

        ], [

            'name.unique' =>
            'Category already exists'

        ]);
        $image = null;

        if ($request->hasFile('image')) {

            $image = $request
                ->file('image')
                ->store(
                    'categories',
                    'public'
                );
        }

        // Category::create([

        //     'name' => $request->name,

        //     'slug' => Str::slug(
        //         $request->name
        //     ),

        //     'description' =>
        //     $request->description,

        //     'status' =>
        //     $request->has(
        //         'status'
        //     ),

        //     'featured' =>
        //     $request->has(
        //         'featured'
        //     ),

        //     'image' => $image

        // ]);
        $category = Category::create([

            'name' => $request->name,

            'slug' => Str::slug(
                $request->name
            ),

            'description' =>
            $request->description,

            'status' =>
            $request->has(
                'status'
            ),

            'featured' =>
            $request->has(
                'featured'
            ),

            'image' => $image

        ]);

        Notification::create([

            'user_id' => Auth::id(),

            'title' => 'Category Created',

            'message' => 'New category "' .
                $category->name .
                '" was added',

            'icon' => 'layers-3'

        ]);

        return back()->with(

            'success',

            'Category saved successfully'

        );
    }

    public function update(
        Request $request,
        Category $category
    ) {

        $data = [

            'name' => $request->name,

            'slug' => Str::slug(
                $request->name
            ),

            'description' => $request->description,

            'status' => $request->has(
                'status'
            ),

            'featured' => $request->has(
                'featured'
            )

        ];

        if ($request->hasFile('image')) {

            if (
                $category->image &&
                Storage::disk('public')->exists(
                    $category->image
                )
            ) {

                Storage::disk('public')
                    ->delete(
                        $category->image
                    );
            }

            $data['image'] = $request
                ->file('image')
                ->store(
                    'categories',
                    'public'
                );
        }

        $category->update(
            $data
        );
        Notification::create([

            'user_id' => Auth::id(),

            'title' => 'Category Updated',

            'message' => 'Category "' .
                $category->name .
                '" was updated',

            'icon' => 'square-pen'

        ]);

        return back()->with(

            'success',

            'Category updated successfully'

        );
    }


    public function destroy(
        Category $category
    ) {

        $category->delete();
        $name = $category->name;

        $category->delete();

        Notification::create([

            'user_id' => Auth::id(),

            'title' => 'Category Deleted',

            'message' => 'Category "' .
                $name .
                '" was deleted',

            'icon' => 'trash'

        ]);
        
        return back()->with(

            'success',

            'Category deleted successfully'

        );
    }

    public function check(
        Request $request
    ) {

        $exists = Category::where(
            'name',
            $request->name
        )

            ->when(
                $request->id,
                fn($q) =>

                $q->where(
                    'id',
                    '!=',
                    $request->id
                )

            )

            ->exists();

        return response()->json([

            'exists' => $exists

        ]);
    }

    public function toggleStatus(
        Category $category
    ) {

        $category->update([

            'status' =>
            !$category->status

        ]);

        return back();
    }

    public function toggleFeatured(
        Category $category
    ) {

        $category->update([

            'featured' =>
            !$category->featured

        ]);

        return back();
    }

    public function bulkDelete(
        Request $request
    ) {

        Category::whereIn(
            'id',
            $request->ids
        )

            ->delete();

        return response()->json([

            'success' => true,

            'message' =>

            'Selected categories deleted'

        ]);
    }

    public function bulkUpdate(
        Request $request
    ) {

        $data = [];

        if (
            $request->has(
                'status'
            )
        ) {

            $data['status'] =
                $request->status;
        }

        if (
            $request->has(
                'featured'
            )
        ) {

            $data['featured'] =
                $request->featured;
        }

        Category::whereIn(
            'id',
            $request->ids
        )

            ->update(
                $data
            );

        return response()->json([

            'success' => true

        ]);
    }

    public function export()
    {
        $fileName = 'categories-report.csv';

        $headers = [

            'Content-Type' => 'text/csv',

            'Content-Disposition' =>

            "attachment; filename=$fileName"

        ];

        $callback = function () {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv(

                $file,

                [

                    'ID',
                    'Category',
                    'Description',
                    'Created At'

                ]

            );

            foreach (

                Category::all()

                as $category

            ) {

                fputcsv(

                    $file,

                    [
                        $category->id,
                        $category->name,
                        $category->description,
                        $category->created_at

                    ]

                );
            }

            fclose($file);
        };

        return response()
            ->stream(
                $callback,
                200,
                $headers
            );
    }
}
