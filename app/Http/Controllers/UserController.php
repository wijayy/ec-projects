<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);

        try {
            DB::beginTransaction();
            User::create($validated);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }

        return back()->with("success", "User berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validateWithBag('editUser', [
            'role_id' => 'nullable|integer',
        ]);
        // dd($user);
        try {
            DB::beginTransaction();
            $user->update(['role_id' => $validated['role_id']]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
        return back()->with("success", "user berhasil diupdate");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->is(Auth::user())) {
            return back()->with("error", "Anda tidak bisa menghapus akun yang Anda gunakan!");
        }

        try {
            DB::beginTransaction();
            $user->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
        return back()->with("success", "User berhasil dihapus");
    }
}