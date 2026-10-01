<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('password.edit');
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ])
                ->withInput();
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('password.edit')
            ->with('success', 'Password berhasil diubah.');
    }
}
