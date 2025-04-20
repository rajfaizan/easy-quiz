<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\UserScore;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('teacher.add_quiz');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quizzes = Quiz::where('teacher_id', auth()->user()->id)->get();

        return view('teacher.myquiz', compact('quizzes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        DB::beginTransaction();

        try {
            $quiz = Quiz::create([
                'teacher_id' => Auth::id(),
                'name' => $request->title,
                'description' => $request->description,
                'semester' => $request->semester,
            ]);

            foreach ($request->questions as $index => $questionText) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'teacher_id' => Auth::id(),
                    'name' => $questionText,
                ]);

                foreach ($request->options[$index] as $optIndex => $optionText) {
                    Option::create([
                        'quiz_id' => $quiz->id,
                        'question_id' => $question->id,
                        'teacher_id' => Auth::id(),
                        'name' => $optionText,
                        'is_correct' => $request->correct_answer[$index] === 'option' . ($optIndex + 1),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Quiz created successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to save quiz: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quiz = Quiz::findOrFail($id);

        return view('teacher.edit_quiz', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreQuizRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $quiz = Quiz::findOrFail($id);

            // Update quiz details
            $quiz->update([
                'name' => $request->title,
                'description' => $request->description,
                'semester' => $request->semester,
            ]);

            // Delete existing questions and options
            $quiz->questions()->delete();

            // Create new questions and options
            foreach ($request->questions as $index => $questionText) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'teacher_id' => Auth::id(),
                    'name' => $questionText,
                ]);

                foreach ($request->options[$index] as $optIndex => $optionText) {
                    Option::create([
                        'quiz_id' => $quiz->id,
                        'question_id' => $question->id,
                        'teacher_id' => Auth::id(),
                        'name' => $optionText,
                        'is_correct' => $request->correct_answer[$index] === 'option' . ($optIndex + 1),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Quiz updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update quiz: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function results(Request $request)
    {
        // dd('hello');
        if ($request->ajax()) {
            try {
                $teacherId = auth()->id();

                $data = UserScore::with(['user', 'quiz'])
                    ->whereHas('quiz', function ($query) use ($teacherId) {
                        $query->where('teacher_id', $teacherId);
                    });


                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', fn($row) => $row->created_at->timezone('Asia/Kolkata')->format('d M, Y h:i A'))
                    ->addColumn('student', fn($row) => $row->user->name ?? 'N/A')
                    ->addColumn('email', fn($row) => $row->user->email ?? 'N/A')
                    ->addColumn('quiz', fn($row) => $row->quiz->name ?? 'N/A')
                    ->addColumn('score_display', function ($row) {
                        $correct = $row->correct_answers ?? 0;
                        $total = $row->total_questions ?? 0;
                        return "✅ {$correct} / {$total}";
                    })
                    ->rawColumns(['score_display']) // Important for <small> tag rendering
                    ->make(true);

            } catch (\Exception $e) {
                Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        return view('teacher.results');
    }
}
