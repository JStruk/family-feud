<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function create(Request $request)
    {
        $questions = Question::query()->inRandomOrder()->limit(5)->with('answers')->get();
        $game = Game::query()->create()->questions()->attach($questions);

        return response([
            "game" => $game,
            "questions" => $questions
        ], 201);
    }
}
