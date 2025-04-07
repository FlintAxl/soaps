@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Register</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <!-- Add this new address field -->
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Profile Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
@endsection
