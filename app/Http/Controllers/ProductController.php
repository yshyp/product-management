<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a paginated list of products with search functionality
    public function index(Request $request)
    {
        $search = $request->query('search'); // Get the search query from the request

        // Retrieve products with variants, applying search filter if provided
        $products = Product::with('variants')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest() // Order the results by creation timestamp in descending order
            ->paginate(2); // Paginate the results

        // Pass products and search query to the view
        return view('products.index', compact('products', 'search'));
    }

    // Display the form for creating a new product
    public function create()
    {
        return view('products.create');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        // Validate the incoming request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants' => 'required|array',
            'variants.*.size' => 'required|string',
            'variants.*.color' => 'required|string',
        ], $this->messages());

        // Handle the main image upload if provided
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('public/products');
            $data['main_image'] = str_replace('public/', '', $imagePath);
        }

        // Create the product and its variants
        $product = Product::create($data);
        foreach ($data['variants'] as $variant) {
            $product->variants()->create($variant);
        }

        // Redirect to the product index page
        return redirect()->route('product.index');
    }

    // Display the form for editing the specified product
    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, $id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Validate the incoming request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants' => 'required|array',
            'variants.*.size' => 'required|string',
            'variants.*.color' => 'required|string',
        ], $this->messages());

        // Handle the main image upload if provided
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('public/products');
            $data['main_image'] = str_replace('public/', '', $imagePath);
        }

        // Update the product and its variants
        $product->update($data);
        $product->variants()->delete(); // Delete existing variants
        foreach ($data['variants'] as $variant) {
            $product->variants()->create($variant);
        }

        // Redirect to the product index page
        return redirect()->route('product.index');
    }

    // Remove the specified product from storage
    public function destroy($id)
    {
        // Find the product by ID and delete it
        $product = Product::findOrFail($id);
        $product->delete();

        // Redirect to the product index page
        return redirect()->route('product.index');
    }

    // Store the uploaded main image and return its URL
    public function storeImage(Request $request)
    {
        $request->validate(['main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        $imagePath = $request->file('main_image')->store('products', 'public');
        return response()->json(['success' => true, 'image_url' => asset('storage/' . $imagePath)]);
    }

    // Custom validation error messages
    protected function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'main_image.image' => 'The main image must be an image file.',
            'main_image.mimes' => 'The main image must be a file of type: jpeg, png, jpg, gif, svg.',
            'main_image.max' => 'The main image may not be greater than 2048 kilobytes.',
            'variants.required' => 'At least one variant is required.',
            'variants.*.size.required' => 'The size field is required for each variant.',
            'variants.*.color.required' => 'The color field is required for each variant.',
        ];
    }
}
