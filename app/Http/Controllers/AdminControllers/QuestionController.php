<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Product;
use Illuminate\Http\Request;

class QuestionController extends Controller {
    /**
     * Store a newly created question (from product page)
     */
    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Question::create([
            'product_id' => $request->product_id,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->back()->with('success', 'Question added successfully');
    }

    /**
     * Update the specified question
     */
    public function update(Request $request, $id){
        $question = Question::findOrFail($id);
        $validator = validator()->make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $question->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        return redirect()->back()->with('success', 'Question updated successfully');
    }

    /**
     * Remove the specified question
     */
    public function destroy($id){
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->back()->with('success', 'Question deleted successfully');
    }

    /**
     * Get question for editing (AJAX)
     */
    public function edit($id){
        $question = Question::with('product')->findOrFail($id);
        return response()->json($question);
    }
}
