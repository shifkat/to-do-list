<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create($validated);

        return redirect()->route('tasks.index')->with('feedback_status', 'Thanks for your feedback!');
    }
}
