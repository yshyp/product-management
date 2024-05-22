<!-- resources/views/products/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Product List</h1>
    <div class="col-8 mb-3">
        <!-- Add mb-3 class for margin bottom -->
        <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
    </div>
    <form action="{{ route('product.index') }}" method="GET" class="mb-4 justify-content-end">
        <div class="input-group">
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" name="search" value="{{ $search }}"
                    placeholder="Search...">
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-sm">Search</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Main Image</th>
                <th>Variants</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
            <tr>
                <td>PRO{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td><img src="{{ asset('storage/' . $product->main_image) }}" width="100" alt="Main Image"></td>
                <td>
                    @foreach ($product->variants as $variant)
                    <p>Size: {{ $variant->size }}, Color: {{ $variant->color }}</p>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links('pagination::bootstrap-4') }}
</div>
@endsection
