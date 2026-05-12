<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievement;
use Illuminate\Support\Facades\Storage;

class ModeratorAchievementController extends Controller
{
    public function achievementsIndex(Request $request)
    {
        $query = Achievement::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', 'newest');

        switch ($sort) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'points':
                $query->orderBy('required_cases', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $achievements = Achievement::whereNull('deleted_at')->paginate(6);

        return view('moderator.achievements.index', compact('achievements'));
    }

    public function createAchievement()
    {
        return view('moderator.achievements.create');
    }

    public function storeAchievement(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'icon' => 'nullable|image|max:2048',
            'required_cases' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('achievements', 'public');
        }

        Achievement::create($data);

        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums izveidots!');
    }

    public function editAchievement(Achievement $achievement)
    {
        return view('moderator.achievements.edit', compact('achievement'));
    }

    public function updateAchievement(Request $request, Achievement $achievement)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'icon' => 'nullable|image|max:2048',
            'required_cases' => 'required|integer|min:1'
        ]);

        if ($request->hasFile('icon')) {

            if ($achievement->icon) {
                Storage::disk('public')->delete($achievement->icon);
            }

            $data['icon'] = $request->file('icon')->store('achievements', 'public');
        }

        $achievement->update($data);

        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums atjaunināts!');
    }

    public function deactivateAchievement(Achievement $achievement)
    {
        $achievement->update(['status' => 'inactive']);
        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums deaktivēts!');
    }

    public function activateAchievement(Achievement $achievement)
    {
        $achievement->update(['status' => 'active']);
        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums aktivēts!');
    }

    public function destroyAchievement(Achievement $achievement)
    {
        if ($achievement->icon) {
            Storage::disk('public')->delete($achievement->icon);
        }
        $achievement->delete();
        return redirect()->route('moderator.achievements.index')->with('success', 'Sasniegums dzēsts!');
    }
}
