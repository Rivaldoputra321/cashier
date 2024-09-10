<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardStaffController extends Controller
{
    public function index()
    {
        
        return view('dashboard.dashboard_create_staff.dashboard_create_staff_index', [
            'staffs' => User::where('role', 'staff')->get(),
        ]);

    }

    public function create()
    {
        return view('dashboard.dashboard_create_staff.dashboard_staff_add');
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required|string|unique:users,name',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'status' => 'active',
            'created_at'=>now(),
        ]);
        return redirect()->route('dashboard_staff.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $name)
    {
        return view('dashboard.dashboard_create_staff.dashboard_create_staff_edit', [
            'staff' => User::where('name', $name)->firstOrFail(),
        ]);
    }

    public function update(Request $request, string $id)
    {

        $staff = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $staff->id,
            'password' => 'required|min:6',          
        ]);



        $staff->update([
            'name' => $request->name,
            'password' => $request->password,
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard_staff.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('dashboard_staff.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
