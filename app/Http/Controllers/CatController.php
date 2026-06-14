<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\RequestType;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function __construct(private TranslationService $translator)
    {
    }

    public function index()
    {
        $categories = Category::orderBy('catName')->get();

        return view('categories.index', compact('categories'));
    }

    public function cat($id)
    {
        $cat = Category::findOrFail($id);
        $reqtypes = RequestType::where('category_id', $cat->id)->orderBy('request_name')->get();

        return view('layouts.cat', compact('cat', 'reqtypes'));
    }

    public function create()
    {
        $categories = Category::orderBy('catName')->get();

        return view('createcat', compact('categories'));
    }

    public function storeCat(StoreCategoryRequest $request)
    {
        $names = $this->translator->resolvePair(
            $request->createdCatName,
            $request->createdCatName_en
        );

        Category::create([
            'catName' => $names['ar'],
            'catName_en' => $names['en'] ?: null,
        ]);

        return redirect()->route('admin.categories.create')->with('success', __('messages.department_added'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('editing.catedit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'createdCatName' => 'required|string|max:255',
            'createdCatName_en' => 'nullable|string|max:255',
        ]);

        $arabic = trim($request->createdCatName);
        $english = trim($request->createdCatName_en ?? '');

        $category = Category::findOrFail($id);
        $category->catName = $arabic;
        $category->catName_en = $english !== '' ? $english : null;
        $category->save();

        return redirect()->route('admin.categories.create')->with('success', __('messages.department_updated'));
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('admin.categories.create')->with('success', __('messages.department_deleted'));
    }
}
