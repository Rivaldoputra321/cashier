<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class DashboardCategoryController extends Controller
{
    public function index (Request $request){

        $categories = Category::all();

        return view('dashboard.dashboard_category.dashboard_category_index', ['categories' => $categories]);
    }

    public function create(){

        return view('dashboard.dashboard_category.dashboard_category_add');

    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories|max:255',
    ]);

    $category = Category::create($request->all());
    return redirect()->route('dashboard_category.index')->with(['success' => 'Data Berhasil Disimpan!']);
}


public function edit($slug)
{
    return view('dashboard.dashboard_category.dashboard_category_edit', [
        'category' => Category::where('slug', $slug)->firstOrFail(),
    ]);
}



public function update(Request $request, $slug)
{
    $category = Category::where('slug', $slug)->first();
    
    $request->validate([
        'name' => 'required|unique:categories|max:255' .$category->id, // contoh validasi
    ]);

    
    $category->slug = null;
    $category->update($request->all());
    return redirect()->route('dashboard_category.index')->with(['success' => 'Data Berhasil Disimpan!']);
}


    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('dashboard_category.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
