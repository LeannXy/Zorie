<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CloudinaryImageStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->search);
        $totalProducts = Product::count();

        $totalStock = Product::sum('stock');

        $outOfStock = Product::where('stock', 0)->count();

        $totalValue = Product::sum(
            DB::raw('price * stock')
        );
        $categories = Category::where(
            'status',
            true
        )->get();
        $categoryData = Category::withCount(
            'products'
        )
            ->get();

        $categoryLabels = $categoryData
            ->pluck('name')
            ->values();

        $categoryTotals = $categoryData
            ->pluck('products_count')
            ->values();

        $lowStock = Product::whereBetween(
            'stock',
            [1, 10]
        )->count();

        $inStock = Product::where(
            'stock',
            '>',
            10
        )->count();


        $products = Product::with([
            'categories',
            'images'
        ])

            ->when(

                $request->search,

                function ($query)
                use ($request) {

                    $query->where(function ($q)
                    use ($request) {

                        $q->where(
                            'name',
                            'like',
                            "%{$request->search}%"
                        )

                            ->orWhereHas(
                                'categories',

                                function ($category)
                                use ($request) {

                                    $category->where(
                                        'name',
                                        'like',
                                        "%{$request->search}%"
                                    );
                                }

                            );
                    });
                }

            )

            ->when(

                $request->category,

                function ($query)
                use ($request) {

                    $query->whereHas(

                        'categories',

                        function ($q)
                        use ($request) {

                            $q->where(
                                'categories.id',
                                $request->category
                            );
                        }

                    );
                }

            )

            ->when(

                $request->stock,

                function ($query)
                use ($request) {

                    if ($request->stock === 'instock') {

                        $query->where(
                            'stock',
                            '>',
                            10
                        );
                    } elseif ($request->stock === 'low') {

                        $query->whereBetween(
                            'stock',
                            [1, 10]
                        );
                    } elseif ($request->stock === 'out') {

                        $query->where(
                            'stock',
                            0
                        );
                    }
                }

            )

            ->orderBy(
                $request->sort ?? 'created_at',
                $request->direction ?? 'desc'
            )
            ->latest()
            ->paginate(10)

            ->withQueryString();

        return view(
            'pages.products.index',
            compact(
                'products',
                'totalProducts',
                'totalStock',
                'outOfStock',
                'totalValue',
                'categoryLabels',
                'categoryTotals',
                'categories',
                'lowStock',
                'inStock'
            )
        );
    }

    public function create()
    {
        $categories = Category::where(
            'status',
            true
        )->get();

        return view(
            'pages.products.create',
            compact('categories')
        );
    }

    public function store(Request $request, CloudinaryImageStorage $imageStorage)
    {
        $product = Product::create([

            'name' => $request->name,

            'price' => $request->price,

            'discount' => $request->discount ?? 0,

            'stock' => collect(
                $request->sizes ?? []
            )->sum('stock'),

            'description' => $request->description,

            'weight' => $request->weight ?? 1000,

        ]);

        foreach ($imageStorage->storeRequestImages($request, 'image', 'products') as $path) {
            $product->images()->create([
                'image' => $path,
            ]);
        }

        // simpan kategori
        $product->categories()->sync(
            $request->categories ?? []
        );

        // simpan ukuran
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                if (!empty($size['size']) && $size['stock'] !== null) {
                    $product->sizes()->create([
                        'size' => $size['size'],
                        'stock' => $size['stock'],
                    ]);
                }
            }
        }

        $this->createNotification(

            'Product Created',

            'New product "' .
                $product->name .
                '" was added',

            'package'

        );

        $this->logActivity(

            'Created product: ' .
                $product->name,

            'package'

        );

        return back()->with(

            'success',

            'Product created successfully'

        );
    }

    public function edit(Product $product)
    {
        $categories = Category::where(
            'status',
            true
        )->get();

        $product->load([
            'categories',
            'images',
            'sizes'
        ]);

        return view(
            'pages.products.edit',
            compact(
                'product',
                'categories'
            )
        );
    }

    public function destroy(Product $product, CloudinaryImageStorage $imageStorage)
    {
        foreach ($product->images as $image) {

            // hapus file dari storage
            $imageStorage->delete($image->image);

            // hapus record gambar
            $image->delete();
        }

        // hapus produk
        $name = $product->name;

        $product->categories()->detach();

        $product->delete();

        $this->createNotification(

            'Product Deleted',

            'Product "' .
                $name .
                '" was deleted',

            'trash'

        );

        $this->logActivity(

            'Deleted product: ' .
                $name,

            'trash'

        );
    }

    public function update(Request $request, Product $product, CloudinaryImageStorage $imageStorage)
    {
        $product->update([

            'name' => $request->name,

            'price' => $request->price,

            'discount' => $request->filled('discount')
                ? $request->discount
                : 0,

            'stock' => collect(
                $request->sizes ?? []
            )->sum('stock'),

            'description' => $request->description,
            'weight' => $request->weight,

        ]);

        // hapus gambar yang disilang user
        if ($request->deleted_images) {

            foreach ($request->deleted_images as $id) {

                $image = $product
                    ->images()
                    ->find($id);

                if ($image) {

                    // hapus file dari storage
                    $imageStorage->delete($image->image);

                    // hapus record database
                    $image->delete();
                }
            }
        }

        // tambah gambar baru
        foreach ($imageStorage->storeRequestImages($request, 'image', 'products') as $path) {
            $product->images()->create([
                'image' => $path,
            ]);
        }
        $product->categories()->sync(
            $request->categories ?? []
        );

        // update ukuran
        if ($request->has('sizes')) {
            $product->sizes()->delete();
            foreach ($request->sizes as $size) {
                if (!empty($size['size']) && $size['stock'] !== null) {
                    $product->sizes()->create([
                        'size' => $size['size'],
                        'stock' => $size['stock'],
                    ]);
                }
            }
        }

        $this->createNotification(

            'Product Updated',

            'Product "' .
                $product->name .
                '" was updated',

            'square-pen'

        );

        $this->logActivity(

            'Updated product: ' .
                $product->name,

            'square-pen'

        );

        return back()->with(

            'success',

            'Product updated successfully'

        );
    }

    public function search(Request $request)
    {
        $products = Product::with(
            'categories'
        )

            ->where(function ($query)
            use ($request) {

                $query->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                )

                    ->orWhereHas(
                        'categories',
                        function ($category)
                        use ($request) {

                            $category->where(
                                'name',
                                'like',
                                '%' . $request->search . '%'
                            );
                        }
                    );
            })

            ->limit(5)

            ->get();

        return response()->json(
            $products
        );
    }

    public function bulkDelete(
        Request $request,
        CloudinaryImageStorage $imageStorage
    ) {

        $request->validate([

            'ids' => 'required|array',

            'ids.*' => 'exists:products,id',

            'weight' => 'required|numeric|min:1',

        ]);

        $products =
            Product::whereIn(
                'id',
                $request->ids
            )->get();

        foreach ($products as $product) {

            foreach (
                $product->images
                as
                $image
            ) {

                $imageStorage->delete($image->image);

                $image->delete();
            }

            $product
                ->categories()
                ->detach();

            $product->delete();
        }

        return response()->json([

            'success' => true,

            'message' =>
            'Products deleted successfully'

        ]);
    }

    public function export()
    {

        $fileName = 'products.csv';

        $products =
            Product::with(
                'categories'
            )->get();

        $response =
            new StreamedResponse(

                function ()
                use ($products) {

                    $handle =
                        fopen(
                            'php://output',
                            'w'
                        );

                    fputcsv(

                        $handle,

                        [

                            'ID',
                            'Name',
                            'Category',
                            'Price',
                            'Stock',
                            'Discount'

                        ]

                    );

                    foreach (
                        $products
                        as
                        $product
                    ) {

                        fputcsv(

                            $handle,

                            [
                                $product->id,

                                $product->name,

                                $product
                                    ->categories
                                    ->pluck('name')
                                    ->join(', '),

                                $product->price,

                                $product->stock,

                                $product->discount

                            ]

                        );
                    }

                    fclose(
                        $handle
                    );
                }

            );

        $response->headers->set(
            'Content-Type',
            'text/csv'
        );

        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="' . $fileName . '"'
        );

        return $response;
    }
}
