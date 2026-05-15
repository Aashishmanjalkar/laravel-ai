<?php

namespace App\Http\Controllers;

use App\Ai\Agents\ChatbotAgent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $response = (new ChatbotAgent)
            ->prompt($request->input('message'));

        return response()->json([
            'reply' => (string) $response,
        ]);
    }
}
