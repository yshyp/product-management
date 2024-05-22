<!-- resources/views/products/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Product</h1>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="main_image" class="form-label">Main Image</label>
            <input type="file" class="form-control @error('main_image') is-invalid @enderror" id="main_image" name="main_image">
            @error('main_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="variants" class="form-label">Variants</label>
            <div id="variant-container">
                <div class="variant mb-2">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control @error('variants.0.size') is-invalid @enderror" name="variants[0][size]" placeholder="Size" value="{{ old('variants.0.size') }}">
                            @error('variants.0.size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <input type="text" class="form-control @error('variants.0.color') is-invalid @enderror" name="variants[0][color]" placeholder="Color" value="{{ old('variants.0.color') }}">
                            @error('variants.0.color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-variant">Add Variant</button>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('product.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.getElementById('add-variant').addEventListener('click', function () {
    const container = document.getElementById('variant-container');
    const index = container.children.length;
    const div = document.createElement('div');
    div.classList.add('variant', 'mb-2');
    div.innerHTML = `
        <div class="row">
            <div class="col">
                <input type="text" class="form-control @error('variants.${index}.size') is-invalid @enderror" name="variants[${index}][size]" placeholder="Size" value="{{ old('variants.${index}.size') }}">
                @error('variants.${index}.size')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" class="form-control @error('variants.${index}.color') is-invalid @enderror" name="variants[${index}][color]" placeholder="Color" value="{{ old('variants.${index}.color') }}">
                @error('variants.${index}.color')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    `;
    container.appendChild(div);
});
</script>
@endsection
