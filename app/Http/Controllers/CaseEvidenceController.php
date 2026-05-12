<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseModel;

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
}
