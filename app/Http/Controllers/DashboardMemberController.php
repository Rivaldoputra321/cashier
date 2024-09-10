<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class DashboardMemberController extends Controller
{
    public function index()
    {
        
        return view('dashboard.dashboard_member.dashboard_member_index', [
            'members' => Member::all(),
        ]);

    }

    public function create()
    {
        return view('dashboard.dashboard_member.dashboard_member_add');
    }

    public function store(Request $request)
{
        // Validate the incoming request
        $validate = $request->validate([
            'name' => 'required|string|unique:customers,name',
            'alamat'=> 'required|string',
            'no_telp'=> 'required|unique:customers,no_telp',
        ]);

        // Get all the request data
        $data = $request->all();

        // Generate the 'kd_member' and add it to the data array
        $data['kd_member'] = $this->generateKodeMember();

        // Create a new customer using the modified data array
        $member =  Member::create($data);

        // Redirect with a success message
        return redirect()->route('dashboard_member.index')->with(['success' => 'Data Berhasil Disimpan!']);
}


    public function edit(string $name)
    {
        return view('dashboard.dashboard_member.dashboard_member_edit', [
            'member' =>  Member::where('name', $name)->firstOrFail(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:customers,name,' . $member->id,
            'alamat' => 'required',
            'no_telp' => 'required',            
        ]);


        $member->update($request->all());

        return redirect()->route('dashboard_member.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    private function generateKodeMember()
    {
        $lastMember = customer::latest()->first();
        $lastNumber = $lastMember ? intval(substr($lastMember->kd_member, 3)) : 0;
        $newNumber = $lastNumber + 1;
        return 'MEM' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Member::findOrFail($id)->delete();

        return redirect()->route('dashboard_member.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
