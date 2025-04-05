@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Register</h2>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" placeholder="Name" required class="form-control">
        <input type="email" name="email" placeholder="Email" required class="form-control mt-2">
        <input type="password" name="password" placeholder="Password" required class="form-control mt-2">
        <input type="file" name="photo" class="form-control mt-2">
        <button type="submit" class="btn btn-success mt-2">Save</button>
    </form>
</div>

<style>
    /* User Form styling to match white and light purple theme */

:root {
    --primary-purple: #9370DB;
    --light-purple: #D8BFD8;
    --very-light-purple: #E6E6FA;
    --hover-purple: #B794F4;
    --text-purple: #4B0082;
    --success-color: #70c285;
    --success-hover: #5aab6f;
}

/* Container styling */
.container {
    margin-top: 2rem;
    margin-bottom: 2rem;
    max-width: 800px;
    padding: 2rem;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(147, 112, 219, 0.1);
}

/* Heading */
h2 {
    color: var(--text-purple);
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--very-light-purple);
}

/* Form controls */
.form-control {
    border: 1px solid var(--light-purple);
    border-radius: 6px;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: var(--primary-purple);
    box-shadow: 0 0 0 0.2rem rgba(147, 112, 219, 0.25);
}

.form-control::placeholder {
    color: #aaa;
    opacity: 0.8;
}

/* File input styling */
input[type="file"].form-control {
    padding: 0.5rem;
    background-color: #f9f9ff;
}

input[type="file"].form-control::file-selector-button {
    background-color: white;
    color: var(--text-purple);
    border: 1px solid var(--light-purple);
    border-radius: 4px;
    padding: 0.375rem 0.75rem;
    margin-right: 1rem;
    transition: all 0.3s;
}

input[type="file"].form-control::file-selector-button:hover {
    background-color: var(--very-light-purple);
    border-color: var(--primary-purple);
}

/* Button styling */
.btn-success {
    background-color: var(--success-color);
    border-color: var(--success-color);
    border-radius: 6px;
    padding: 0.75rem 2rem;
    font-weight: 500;
    transition: all 0.3s;
    color: white;
}

.btn-success:hover {
    background-color: var(--success-hover);
    border-color: var(--success-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(92, 184, 92, 0.2);
}

.btn-success:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(92, 184, 92, 0.1);
}

/* Animation for form elements */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.container {
    animation: fadeIn 0.5s ease-out;
}

.form-control, .btn {
    animation: fadeIn 0.5s ease-out;
    animation-fill-mode: both;
}

.form-control:nth-child(1) {
    animation-delay: 0.1s;
}

.form-control:nth-child(2) {
    animation-delay: 0.2s;
}

.form-control:nth-child(3) {
    animation-delay: 0.3s;
}

.form-control:nth-child(4) {
    animation-delay: 0.4s;
}

.btn {
    animation-delay: 0.5s;
}

/* Validation feedback */
.is-invalid {
    border-color: #FF6B81;
}

.invalid-feedback {
    color: #FF6B81;
    font-size: 0.875rem;
    margin-top: -0.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 1.5rem;
    }

    .form-control {
        padding: 0.625rem 0.875rem;
    }

    .btn-success {
        width: 100%;
    }
}
</style>
@endsection
