<?php

namespace App\Http\Controllers\Case;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CaseModel;
use App\Models\Suspect;
use Illuminate\Support\Facades\Auth;

class CaseSuspectController extends Controller
{
    public function suspects(CaseModel $case)
    {
        $suspects = $case->suspects()->get();

        return view('cases.wizard.suspects', compact('case', 'suspects'));
    }

    public function storeSuspect(Request $request, CaseModel $case)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cases/suspects', 'public');
            $imagePath = 'storage/' . $path;
        }

        $case->suspects()->create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('cases.suspects', $case->id)
            ->with('status', 'Aizdomās turamais pievienots!');
    }

    public function setAnswer(Request $request, CaseModel $case)
    {
        $request->validate([
            'answer_id' => 'required|exists:suspects,id'
        ]);

        $case->answer_id = $request->answer_id;
        $case->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vainīgais saglabāts!',
                'answer_id' => $case->answer_id,
                'suspect_name' => $case->suspect->name ?? null
            ]);
        }

        return redirect()->back()->with('success', 'Vainīgais saglabāts!');
    }

    public function destroy(CaseModel $case, int $suspectId)
    {
        $suspect = Suspect::findOrFail($suspectId);

        if ($suspect->case->user_id != Auth::id()) {
            abort(403);
        }

        if ($suspect->image_path && file_exists(public_path($suspect->image_path))) {
            unlink(public_path($suspect->image_path));
        }

        if ($case->answer_id == $suspect->id) {
            $case->answer_id = null;
            $case->save();
        }

        $suspect->delete();

        return back()->with('status', 'Aizdomās turamais dzēsts');
    }
}
