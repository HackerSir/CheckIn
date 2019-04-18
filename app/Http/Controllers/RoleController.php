<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::with('roles')->get();

        return view('role.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();

        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|unique:roles,name',
            'display_name' => 'required',
            'permissions'  => 'array',
        ]);

        /** @var Role $role */
        $role = Role::create([
            'name'         => $request->input('name'),
            'display_name' => $request->input('display_name'),
            'description'  => $request->input('description'),
            'protection'   => false,
        ]);
        $role->permissions()->sync($request->input('permissions') ?: []);

        return redirect()->route('role.index')->with('success', '角色已建立');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name'         => 'required|unique:roles,name,' . $role->id . ',id',
            'display_name' => 'required',
            'permissions'  => 'array',
        ]);

        if ($role->protection) {
            $role->update([
                'display_name' => $request->input('display_name'),
                'description'  => $request->input('description'),
            ]);
        } else {
            $role->update([
                'name'         => $request->input('name'),
                'display_name' => $request->input('display_name'),
                'description'  => $request->input('description'),
            ]);
            $role->permissions()->sync($request->input('permissions') ?: []);
        }

        return redirect()->route('role.index')->with('success', '角色已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        if ($role->protection) {
            return back()->with('warning', '無法刪除受保護角色');
        }
        $role->delete();

        return redirect()->route('role.index')->with('success', '角色已刪除');
    }
}
