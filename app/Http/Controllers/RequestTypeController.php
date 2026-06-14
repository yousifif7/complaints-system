<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestTypeRequest;
use App\Models\Category;
use App\Models\RequestType;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class RequestTypeController extends Controller
{
    public function __construct(private TranslationService $translator)
    {
    }

    public function create()
    {
        $categories = Category::orderBy('catName')->get();
        $requesttypes = RequestType::with('category')->orderBy('request_name')->get();

        return view('createreq_type', compact('categories', 'requesttypes'));
    }

    public function store(StoreRequestTypeRequest $request)
    {
        $names = $this->translator->resolvePair(
            $request->createdRequest,
            $request->createdRequest_en
        );

        RequestType::create([
            'request_name' => $names['ar'],
            'request_name_en' => $names['en'] ?: null,
            'category_id' => $request->formCat,
        ]);

        return redirect()->route('admin.requesttypes.create')->with('success', __('messages.request_type_added'));
    }

    public function edit($id)
    {
        $reqtype = RequestType::findOrFail($id);
        $categories = Category::orderBy('catName')->get();

        return view('editing.reqtype_edit', compact('reqtype', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'createdRequest' => 'required|string|max:255',
            'createdRequest_en' => 'nullable|string|max:255',
            'formCat' => 'required|exists:categories,id',
        ]);

        $arabic = trim($request->createdRequest);
        $english = trim($request->createdRequest_en ?? '');

        $reqtype = RequestType::findOrFail($id);
        $reqtype->request_name = $arabic;
        $reqtype->request_name_en = $english !== '' ? $english : null;
        $reqtype->category_id = $request->formCat;
        $reqtype->save();

        return redirect()->route('admin.requesttypes.create')->with('success', __('messages.request_type_updated'));
    }

    public function destroy($id)
    {
        RequestType::findOrFail($id)->delete();

        return redirect()->route('admin.requesttypes.create')->with('success', __('messages.request_type_deleted'));
    }
}
