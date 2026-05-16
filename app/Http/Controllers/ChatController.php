<?php

namespace App\Http\Controllers;

use App\Ai\Agents\ChatbotAgent;
use Illuminate\Http\Request;
use App\Ai\Agents\ProductAgent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Ai\Responses\StreamableAgentResponse;
use Laravel\Ai\Responses\StreamedAgentResponse;

class ChatController extends Controller
{
    // public function index()
    // {
    //     return view('chat');
    // }

    // public function ask(Request $request)
    // {
    //     $request->validate([
    //         'message' => 'required|string|max:1000',
    //     ]);

    //     $response = (new ChatbotAgent)
    //         ->prompt($request->input('message'));

    //     return response()->json([
    //         'reply' => (string) $response,
    //     ]);
    // }

    public function index()
    {
        return view('chat');
    }

    public function stream(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ]);

        $user = $this->resolveUser();

        $conversationId = $this->resolveConversation($user);

        $stream = $conversationId
            ? (new ProductAgent)
                ->continue($conversationId, as: $user)
                ->stream($request->message)
            : (new ProductAgent)
                ->forUser($user)
                ->stream($request->message);

      return $stream->then(function ($response) {
    if ($response->conversationId) {
        session([
            'product_agent_conversation_id' => $response->conversationId,
        ]);
    }
});
    }

    protected function resolveUser()
    {
        if (! auth()->check()) {
            $user = User::first();
            auth()->login($user);
        }

        return auth()->user();
    }

    protected function resolveConversation($user): ?string
    {
        return session('product_agent_conversation_id')
            ?? DB::table('agent_conversations')
                ->where('user_id', $user->id)
                ->latest('updated_at')
                ->value('id');
    }

}
