<?php

namespace App\Http\Controllers;

use App\Models\UserScore;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $authUser = auth()->user();
    
            // ✅ Use semester from the user's profile, not the latest quiz
            $semester = $authUser->semester;
    
            if (!$semester) {
                return DataTables::of(collect())->make(true); // Return empty if no semester set
            }
    
            // Fetch top scores in the same semester
            $scores = UserScore::with(['quiz', 'user'])
                ->whereHas('quiz', fn($q) => $q->where('semester', $semester))
                ->orderByDesc('score')
                ->get()
                ->unique('user_id') // Only highest score per user if needed
                ->take(10); // Top 10
    
            return DataTables::of($scores)
                ->addIndexColumn()
                ->addColumn('user_name', fn($score) => $score->user->name)
                ->addColumn('score_display', fn($score) => "{$score->correct_answers} / {$score->total_questions}")
                ->addColumn('percentage', fn($score) => $score->percentage . '%')
                ->addColumn('is_current_user', fn($score) => $score->user_id === $authUser->id ? 'You' : '')
                ->rawColumns(['is_current_user'])
                ->make(true);
        }
    
        return view('user.ranking');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
