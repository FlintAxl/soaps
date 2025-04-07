@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit My Profile</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Profile Photo</label>
            <input type="file" name="photo" class="form-control">
            @if ($user->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" width="100" alt="Current Photo">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_photo" id="remove_photo">
                        <label class="form-check-label" for="remove_photo">
                            Remove current photo
                        </label>
                    </div>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
