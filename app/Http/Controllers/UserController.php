<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;//pang debug
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

   

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:3',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('photos', 'public');
    }

    // Log the data before saving
    Log::info('Creating User:', [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'photo' => $photoPath
    ]);

    // Save the user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'photo' => $photoPath,
    ]);

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $photoPath]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    //para sa status ng active or inactive
    public function updateStatus(Request $request, User $user)
{
    $user->status = $request->status;
    $user->save();

    return redirect()->route('users.index')->with('success', 'User status updated successfully.');
}
//update role
public function updateRole(Request $request, User $user)
{
    $user->role = $request->role;
    $user->save();

    return redirect()->route('users.index')->with('success', 'User role updated successfully.');
}

// Show user's own profile
public function showProfile()
{
    $user = auth()->user();
    return view('users.profile.show', compact('user'));
}

// Edit user's own profile
public function editProfile()
{
    $user = auth()->user();
    return view('users.profile.edit', compact('user'));
}

//user udate profile
public function updateProfile(Request $request)
{
    $user = auth()->user();
    
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('photos', 'public');
        $user->photo = $photoPath;
    } elseif ($request->has('remove_photo')) {
        $user->photo = null;
    }

    $user->save();

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}

}

