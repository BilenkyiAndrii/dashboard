<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeleteUserController extends Controller
{
    public function destroy(User $user)
    {
        // Виконайте додаткову логіку перед видаленням користувача, якщо необхідно
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
