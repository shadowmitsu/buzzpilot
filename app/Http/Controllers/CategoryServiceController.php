<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::paginate(50);
        return view('category_services.index', compact('categories'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!empty($ids)) {
            Service::whereIn('category_id', $ids)
                ->delete();
            Category::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Categories deleted successfully.');
        }

        return redirect()->back()->with('error', 'No categories selected.');
    }

    public function delete($id)
    {
        Service::where('category_id', $id)
                ->delete();
        Category::find($id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $category = Category::find($id);
        $category->status = !$category->status;
        $category->save();

        return redirect()->back()->with('success', 'Category status updated successfully.');
    }
}
