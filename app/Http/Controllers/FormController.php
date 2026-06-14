<?php

namespace App\Http\Controllers;

use App\Enums\ComplaintStatus;
use App\Http\Requests\StoreComplaintRequest;
use App\Models\Category;
use App\Models\ComplaintNote;
use App\Models\FormType;
use App\Models\RequestType;
use App\Support\ComplaintFileStorage;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function requests(Request $request)
    {
        $query = FormType::with(['category', 'requestType'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('ticket_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $myrequest = $query->paginate(25)->withQueryString();
        $category = Category::orderBy('catName')->get();
        $requesttype = RequestType::orderBy('request_name')->get();

        return view('formsview', compact('myrequest', 'category', 'requesttype'));
    }

    public function store(StoreComplaintRequest $request)
    {
        $fileName = '';

        if ($request->hasFile('userfile')) {
            $fileName = ComplaintFileStorage::store($request->file('userfile'));
        }

        $complaint = FormType::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'content' => $request->content,
            'file' => $fileName,
            'status' => ComplaintStatus::ACTIVE,
            'requesttype_id' => $request->formtype,
            'category_id' => $request->category,
        ]);

        return redirect()
            ->route('complaints.track.show', $complaint->ticket_number)
            ->with('success', __('messages.complaint_submitted'))
            ->with('ticket_number', $complaint->ticket_number);
    }

    public function show($id)
    {
        $myrequest = FormType::with(['category', 'requestType', 'notes.user'])->findOrFail($id);

        return view('viewDetails', compact('myrequest'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3',
            'internal_notes' => 'nullable|string|max:5000',
            'priority' => 'nullable|in:low,medium,high,urgent',
        ]);

        $form = FormType::findOrFail($id);
        $oldStatus = $form->status;

        $form->status = $request->status;
        $form->priority = $request->priority ?? $form->priority;

        if ($request->filled('internal_notes')) {
            $form->internal_notes = $request->internal_notes;
            ComplaintNote::create([
                'form_type_id' => $form->id,
                'user_id' => auth()->id(),
                'note' => $request->internal_notes,
                'type' => 'internal',
            ]);
        }

        $form->save();

        if ($oldStatus !== $form->status) {
            ComplaintNote::create([
                'form_type_id' => $form->id,
                'user_id' => auth()->id(),
                'note' => __('messages.status_changed_to', ['status' => ComplaintStatus::label($form->status)]),
                'type' => 'status_change',
            ]);
        }

        return redirect()->route('admin.forms')->with('success', __('messages.complaint_updated'));
    }

    public function destroy($id)
    {
        $form = FormType::findOrFail($id);

        ComplaintFileStorage::delete($form->file);

        $form->delete();

        return redirect()->route('admin.forms')->with('success', __('messages.complaint_deleted'));
    }

    public function deleteAll()
    {
        FormType::query()->delete();

        return redirect()->route('admin.forms')->with('success', __('messages.all_complaints_deleted'));
    }

    public function deleteCompleted()
    {
        FormType::where('status', ComplaintStatus::COMPLETED)->delete();

        return redirect()->route('admin.forms')->with('success', __('messages.completed_complaints_deleted'));
    }
}
