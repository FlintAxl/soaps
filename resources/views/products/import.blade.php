@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Import Products</h2>
    <form action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
</div>
@endsection
