<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // 1. Save the message from the "Contact Us" page
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'message' => 'required|string',
        ]);

        $message = Message::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $message
        ], 201);
    }

    // 2. Fetch all messages for your Admin Dashboard
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return response()->json($messages, 200);
    }
}
