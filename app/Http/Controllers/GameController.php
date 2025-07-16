<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
        public function index()
    {

        if(!Session::has('number')){

            $randomNumber = rand(1, 10);
            Session::put('number', $randomNumber);
            Session::put('attempts', 0);
        }

        $game = Game::where('user_id', auth()->id())->first();
        $bestScore = $game?->best_score;

        return view('game', compact('bestScore'));
    }

    public function guess(Request $request)
    {
        $guess = (int) $request->input('guess');
        $number = Session::get('number');
        $attempts = Session::increment('attempts');
        if ($guess == $number) {
            $game = Game::firstOrCreate(['user_id' => auth()->id()]);
            if (is_null($game->best_score) || $attempts < $game->best_score) {
                $game->best_score = $attempts;
                $game->save();
            }

            Session::forget(['number', 'attempts']);

            return redirect()->route('game.index')->with('message', "Correct! You guessed it in $attempts tries.");
        }

        $hint = $guess < $number ? 'Higher' : 'Lower';
        return redirect()->back()->with('hint', $hint);
    }
}
