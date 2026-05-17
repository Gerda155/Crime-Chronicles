<?php

namespace App\Http\Controllers\Case;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Evidence;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CaseEvidenceController extends Controller
{
    public function evidence(CaseModel $case)
    {
        $evidence = $case->evidence()->get();

        return view('cases.wizard.evidence', compact('case', 'evidence'));
    }

    public function storeEvidence(Request $request, CaseModel $case)
    {
        $request->validate([
            'description' => 'required|string',
            'file' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
            'key_object_area' => 'nullable|json',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('cases/evidence', 'public');
            $filePath = 'storage/' . $path;
        }

        $case->evidence()->create([
            'description' => $request->description,
            'type' => $request->type ?? 'image',
            'image_path' => $filePath,
            'key_object_area' => $request->key_object_area,
        ]);

        return redirect()
            ->route('cases.evidence', $case->id)
            ->with('status', 'Pierādījums pievienots!');
    }

    public function destroy(int $caseId, int $evidenceId)
    {
        $evidence = Evidence::findOrFail($evidenceId);

        if ($evidence->case->user_id != Auth::id()) abort(403);

        if ($evidence->image_path && file_exists(public_path($evidence->image_path))) {
            unlink(public_path($evidence->image_path));
        }

        $evidence->delete();

        return back()->with('status', 'Pierādījums dzēsts');
    }
}
