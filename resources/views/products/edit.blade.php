@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Product</h1>
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="main_image" class="form-label">Main Image</label>
                <input type="file" class="form-control" id="main_image" name="main_image">
                @if($product->main_image)
                    <img src="{{ asset('storage/'.$product->main_image) }}" width="100" alt="Main Image">
                @endif
            </div>
            <div id="variants">
                <h4>Variants</h4>
                @foreach($product->variants as $index => $variant)
                    <div class="variant">
                        <div class="mb-3">
                            <label for="variants[{{ $index }}][size]" class="form-label">Size</label>
                            <input type="text" class="form-control" id="variants[{{ $index }}][size]" name="variants[{{ $index }}][size]" value="{{ $variant->size }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="variants[{{ $index }}][color]" class="form-label">Color</label>
                            <input type="text" class="form-control" id="variants[{{ $index }}][color]" name="variants[{{ $index }}][color]" value="{{ $variant->color }}" required>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-variant" class="btn btn-secondary">Add Variant</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    let variantIndex = {{ $product->variants->count() }};
    document.getElementById('add-variant').addEventListener('click', function () {
        let variantsDiv = document.getElementById('variants');
        let newVariantDiv = document.createElement('div');
        newVariantDiv.classList.add('variant');
        newVariantDiv.innerHTML = `
            <div class="mb-3">
                <label for="variants[${variantIndex}][size]" class="form-label">Size</label>
                <input type="text" class="form-control" id="variants[${variantIndex}][size]" name="variants[${variantIndex}][size]" required>
            </div>
            <div class="mb-3">
                <label for="variants[${variantIndex}][color]" class="form-label">Color</label>
                <input type="text" class="form-control" id="variants[${variantIndex}][color]" name="variants[${variantIndex}][color]" required>
            </div>
        `;
        variantsDiv.appendChild(newVariantDiv);
        variantIndex++;
    });
</script>
@endpush
