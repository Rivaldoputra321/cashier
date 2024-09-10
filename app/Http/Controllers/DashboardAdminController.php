<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardAdminController extends Controller
{
    public function inactive(Request $request)
    {
        $inactives = User::where('role', 'admin')->where('status', 'inactive')->get();
        return view('dashboard.dashboard_admin.dashboard_admin_inactive', [
            'inactives' => $inactives
        ]);
    }
    
    public function activate($id)
{
    // Mengambil data user yang statusnya inactive
    $user = User::findOrFail($id);

    // Mengubah status menjadi active
    $user->status = 'active';
    $user->save();

    // Redirect kembali ke halaman sebelumnya atau halaman lain dengan pesan sukses
    return redirect()->route('dashboard_inactive')->with('success', 'User status has been updated to active.');
}


    public function index()
    {

        $admins = User::where('role', 'admin')->where('status', 'active')->get();
        return view('dashboard.dashboard_admin.dashboard_admin_index', [
            'admins' => $admins
        ]);

    }

    public function create()
    {
        return view('dashboard.dashboard_admin.dashboard_admin_add');
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
            'role' => 'admin',
            'status' => 'active',
            'created_at'=>now(),
        ]);
        return redirect()->route('dashboard_admin.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $name)
    {
        return view('dashboard.dashboard_admin.dashboard_admin_edit', [
            'admin' => User::where('name', $name)->firstOrFail(),
        ]);
    }

    public function update(Request $request, string $id)
    {

        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $admin->id,
            'password' => 'required|min:6',          
        ]);



        $admin->update([
            'name' => $request->name,
            'password' => $request->password,
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard_admin.index')->with(['success' => 'Data Berhasil Disimpan!']);
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

        return redirect()->route('dashboard_admin.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
