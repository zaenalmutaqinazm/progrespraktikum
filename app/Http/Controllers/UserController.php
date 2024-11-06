<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        }
        return redirect()->route('users.index')->with('error', 'User tidak ditemukan.');
    }
}

