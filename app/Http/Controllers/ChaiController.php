<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChaiController extends Controller
{
    public function generate(Request $request)
    {
        // Validate the request input
        $request->validate([
            'prompt' => 'required|string'
        ]);

        // Call the API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-rapidapi-host' => 'cheapest-gpt-4-turbo-gpt-4-vision-chatgpt-openai-ai-api.p.rapidapi.com',
            'x-rapidapi-key' => '15e9f901cfmsh99f13d1552365aap1a2e98jsn05da2723d2df',
        ])->post('https://cheapest-gpt-4-turbo-gpt-4-vision-chatgpt-openai-ai-api.p.rapidapi.com/v1/chat/completions', [
            'messages' => [
                ['role' => 'user', 'content' => $request->input('prompt')]
            ],
            'model' => 'gpt-4o',
            'max_tokens' => 100,
            'temperature' => 0.9
        ]);

        return response()->json($response->json());
    }
}
