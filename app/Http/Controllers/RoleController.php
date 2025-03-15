<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\HakAkses;
use App\Models\Role;
use App\Models\RolesHakAkses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $role = Role::all();
        $hakAkses = HakAkses::all();
        return view('role.index', compact('users', 'role', 'hakAkses'));
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
        $validated = $request->validateWithBag('tambahRole', [
            'nama' => 'required|string',
            'option' => 'nullable|array',
            'option.*' => 'integer'
        ]);

        // dd($validated);

        try {
            DB::beginTransaction();
            $role = Role::create($validated);

            foreach ($validated['option'] as $key => $item) {
                RolesHakAkses::create([
                    'role_id' => $role->id,
                    'hak_akses_id' => $item
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }

        return back()->with('success', "Role Berhasil dibuat");
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();

            foreach ($role->roleHakAkses as $key => $item) {
                $item->delete();
            }

            foreach ($validated['option'] as $key => $item) {
                RolesHakAkses::create([
                    'role_id' => $role->id,
                    'hak_akses_id' => $item
                ]);
            }

            $role->update($validated);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }

        return back()->with('success', "Role Berhasil diedit");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            DB::beginTransaction();
            User::where('role_id', $role->id)->update(['role_id' => null]);
            RolesHakAkses::where('role_id', $role->id)->delete();

            $role->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            if (config('app.debug') == true) {
                throw $th;
            } else {
                return back()->with('error', $th->getMessage());
            }
        }
        return back()->with('success', "Role Berhasil dihapus");
    }
}