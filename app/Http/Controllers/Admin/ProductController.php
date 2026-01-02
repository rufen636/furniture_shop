<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Services\Admin\Product\CrudService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    protected CrudService $crudProductService;
    public function __construct(CrudService $crudProductService){
        $this->crudProductService = $crudProductService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->latest()
            ->paginate($request->input('per_page', 5));

        $categories = Category::all();

        $productsArray = $products->toArray();

//        dd($productsArray);
        return Inertia::render('Admin/Product/Index', [
            'products' => $productsArray['data'], // Только массив товаров
            'categories' => CategoryResource::collection($categories)->resolve(),
            'pagination' => $productsArray, // Весь объект пагинации
        ]);
    }

    public function create()
    {
        $categories = CategoryResource::collection(Category::all())->resolve();
        $colors = Color::all()->toArray();
        return Inertia::render('Admin/Product/Create', ['categories' => $categories, 'colors' => $colors]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        $product = $this->crudProductService->store($data);
        return response()->json(['message'=>'Product created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        dd($request);
        $this->crudProductService->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product Deleted'], 201);
    }
    public function edit(Product $product)
    {

        $categories = CategoryResource::collection(Category::all())->resolve();
        $colors = Color::all()->toArray();
        $product = ProductResource::make($product)->resolve();
//        dd($product);
        return Inertia::render('Admin/Product/Edit', ['product' => $product, 'categories' => $categories, 'colors' => $colors]);
    }
}
