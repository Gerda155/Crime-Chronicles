<?php

namespace App\Http\Controllers\Case;

use Illuminate\Http\Request;
use App\Models\CaseModel;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;


class CaseController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseModel::with('genre')
            ->where('status', 'active');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'newest');

        switch ($sort) {

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'rating':
                $query->orderBy('rating', 'desc');
                break;

            case 'alphabet':
                $query->orderBy('title', 'asc');
                break;

            case 'alphabet_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'tutorials':
                $query->where('is_tutorial', 1)
                    ->orderBy('created_at', 'desc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $cases = $query->paginate(9)->withQueryString();
        return view('cases.index', compact('cases'));
    }

    public function myCases(Request $request)
    {
        $user = Auth::user();
        $user = $user instanceof User ? $user : null;

        $query = CaseModel::with('genre')
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'genre':
                $query->join('genres', 'cases.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', 'asc')
                    ->select('cases.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $cases = $query->paginate(10)->withQueryString();

        return view('cases.my-cases', compact('cases'));
    }

    public function edit(int $id)
    {
        $case = CaseModel::findOrFail($id);

        if ($case->user_id != Auth::id()) abort(403);

        $genres = Genre::all();

        return view('cases.wizard.create', [
            'case' => $case,
            'genres' => $genres,
            'editMode' => true
        ]);
    }

    public function updateBasic(Request $request, int $id)
    {
        $case = CaseModel::findOrFail($id);

        if ($case->user_id != Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $case->update([
            'title' => $request->title,
            'description' => $request->description,
            'genre_id' => $request->genre_id,
            'status' => 'pending'
        ]);

        return redirect()->route('cases.suspects', $case->id);
    }

    public function update(Request $request, int $id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->update($request->all());
        return redirect()->route('cases.my-cases');
    }

    public function destroy(int $id)
    {
        $case = CaseModel::findOrFail($id);
        if ($case->user_id != Auth::id()) abort(403);

        $case->delete();
        return redirect()->route('cases.my-cases');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $case = CaseModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'genre_id' => $request->genre_id,
            'user_id' => Auth::id(),
            'status' => 'draft',
            'rating' => 0,
            'is_tutorial' => false,
        ]);

        return redirect()->route('cases.suspects', $case->id);
    }

    public function create()
    {
        $genres = Genre::all();

        return view('cases.wizard.create', compact('genres'));
    }

    public function submitFinal(CaseModel $case)
    {
        if ($case->status !== 'draft') {
            return redirect()->route('cases.my-cases')
                ->with('status', 'Šī lieta jau ir iesniegta.');
        }

        $case->update([
            'status' => 'pending'
        ]);

        return redirect()->route('cases.my-cases')
            ->with('status', 'Lieta nosūtīta uz moderāciju. Drīz tā parādīsies vietnē!');
    }

    public function toggleStatus(CaseModel $case)
    {
        if (!in_array($case->status, ['approved', 'active', 'inactive'])) {
            return back()->with('error', 'Šim statusam nevar mainīt stāvokli.');
        }

        if ($case->status === 'approved') {
            $case->status = 'active';
        } elseif ($case->status === 'active') {
            $case->status = 'inactive';
        } else {
            $case->status = 'active';
        }

        $case->save();

        return back()->with('status', 'Statuss atjaunināts');
    }

    public function comments(int $id)
    {
        $case = CaseModel::with('ratings.user')->findOrFail($id);

        return view('cases.comments', compact('case'));
    }
}
