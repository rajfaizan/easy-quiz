<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserScore;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::where('semester', auth()->user()->semester)->get();

        return view('user.quiz_home', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(request()->ajax()){
            $scores = UserScore::with('quiz')
                ->where('user_id', auth()->id())->get();
    
            return DataTables::of($scores)
                ->addIndexColumn()
                ->addColumn('quiz_name', fn($score) => $score->quiz->name ?? '-')
                ->addColumn('semester', fn($score) => $score->quiz->semester ?? '-')
                ->addColumn('score_display', fn($score) => "{$score->correct_answers} / {$score->total_questions}")
                ->addColumn('attempted_at', fn($score) => $score->created_at->diffForHumans()) // ✅ Here!
                ->make(true);
        }

        return view('user.my_score');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|integer|min:1|max:6',
        ]);
    
        $user = auth()->user();
        $user->semester = $request->semester;
        $user->save();
    
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.options']); // eager load

        return view('user.quiz_interface', compact('quiz'));
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function score(Request $request, $id)
    {

        $user = auth()->user();
        $answers = $request->input('answers', []);

        $quiz = Quiz::with('questions.options')->findOrFail($id);

        $correct = 0;
        $total = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $correctOption = $question->options()->where('is_correct', true)->first();
            if (isset($answers[$question->id]) && $answers[$question->id] == $correctOption->id) {
                $correct++;
            }
        }

        $score = $correct; // you can add weighting if needed
        $percentage = ($correct / $total) * 100;

        // Save to user_scores
        UserScore::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'total_questions' => $total,
            'correct_answers' => $correct,
            'percentage' => round($percentage, 2),
            'score' => $score,
        ]);

        return response()->json([
            'message' => 'Quiz submitted successfully!',
            'correct' => $correct,
            'total' => $total,
            'percentage' => round($percentage, 2),
        ]);
    }
}
