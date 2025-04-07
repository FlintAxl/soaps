@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Profile</h2>
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" class="img-fluid rounded-circle" alt="Profile Photo">
                    @else
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                            <i class="fas fa-user fa-5x text-white"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ $user->name }}</h3>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Status:</strong> {{ $user->status ? 'Active' : 'Inactive' }}</p>
                    
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection