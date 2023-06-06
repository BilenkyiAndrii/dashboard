<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class InfoUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('laravel-examples.user-management', compact('users'));
    }

    public function create()
    {
        return view('laravel-examples.create-user');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users')->ignore(Auth::user() ? Auth::user()->id : null)
            ],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'password' => ['required', 'min:6'],
            'phone' => ['max:50'],
            'location' => ['max:70'],
            'about_me' => ['max:150'],
        ]);

        $user = new User();

        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->password = bcrypt($attributes['password']);
        $user->phone = $attributes['phone'];
        $user->location = $attributes['location'];
        $user->about_me = $attributes['about_me'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $user->image = 'images/' . $imageName; // Змінено шлях збереження зображення
        }

        $user->save();

        return redirect()->back()->with('success', 'User created successfully.');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users')->ignore($user->id)
            ],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'password' => ['nullable', 'min:6'], // Редагування паролю за бажанням
            'phone' => ['max:50'],
            'location' => ['max:70'],
            'about_me' => ['max:150'],
        ]);

        $user->name = $attributes['name'];
        $user->email = $attributes['email'];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $user->image = 'images/' . $imageName; // Змінено шлях збереження зображення
        }

        if (!empty($attributes['password'])) {
            $user->password = bcrypt($attributes['password']);
        }

        $user->phone = $attributes['phone'];
        $user->location = $attributes['location'];
        $user->about_me = $attributes['about_me'];

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

}
