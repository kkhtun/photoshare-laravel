<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\CategoryPost;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showCreateForm()
    {
        return view('admin.categories.create', [
            "title" => "Create New Category",
            "submitRoute" => "admin.categories.store",
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request, 'store');
        DB::beginTransaction();
        try {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Helper::makeSlug($request->name);
            $category->save();
            DB::commit();
            return redirect()->route('admin.categories')->with('status', 'Category created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showEditForm($id)
    {
        $category = Category::find($id);
        if (!$category) abort(404);
        return view('admin.categories.create', [
            "title" => "Edit Category",
            "submitRoute" => "admin.categories.update",
            "category" => $category,
        ]); // Using same form for edit/create
    }

    public function update(Request $request)
    {
        $this->validator($request, 'update');
        DB::beginTransaction();
        try {
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->slug = Helper::makeSlug($request->name);
            $category->update();
            DB::commit();
            return redirect()->route('admin.categories')->with('status', 'Category updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function showDeleteForm($id)
    {
        $category = Category::find($id);
        if (!$category) abort(404);
        return view('admin.categories.delete', [
            "title" => "Delete Category",
            "submitRoute" => "admin.categories.destroy",
            "category" => $category,
        ]);
    }

    public function destroy(Request $request)
    {
        $this->validator($request, 'destroy');
        try {
            $category = Category::find($request->id);
            $category->delete();
            CategoryPost::where('category_id', $category->id)->delete();
            DB::commit();
            return redirect()->route('admin.categories')->with('status', 'Category deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function validator(Request $request, $reqType = "store")
    {
        $rules = [];
        if ($reqType === 'store') {
            $rules['name'] = "required|string|unique:categories";
        }
        if ($reqType === 'update') {
            $rules['id'] = "required|integer|exists:categories";
            $rules['name'] = "required|string|unique:categories,name,$request->id";
        }
        if ($reqType === 'destroy') {
            $rules['id'] = "required|integer|exists:categories";
        }
        $request->validate($rules);
    }
}
