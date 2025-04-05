@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $product->name }}" required>
        <input type="text" name="description" value="{{ $product->description }}" required>
        <input type="number" name="price" value="{{ $product->price }}" required>
        <input type="number" name="stock" value="{{ $product->stock }}" required>

        <label>Current Images:</label><br>
        @foreach($product->images as $image)
            <img src="{{ asset('storage/' . $image->image_path) }}" width="50">
        @endforeach

        <input type="file" name="images[]" multiple> <!-- Allow new image uploads -->

        <button type="submit">Update</button>
    </form>
</div>
@endsection
