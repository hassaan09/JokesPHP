<?php

namespace App\Http\Controllers;

use App\Models\Joke;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class JokeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('joke')) {
            $this->fetchJoke($request);
        }

        $joke = $request->session()->get('joke');

        return view('dashboard', ['joke' => $joke]);
       
    }

    public function fetchJoke(Request $request)
    {
        $joke = '';

        $response = Http::get('https://v2.jokeapi.dev/joke/Any'); 
        if ($response->successful()) {
            $jokeData = $response->json();
        
            if ($jokeData['type'] === 'twopart') {
                $joke = $jokeData['setup'] . ' ' . $jokeData['delivery'];
            } else {
                $joke = $jokeData['joke'];
            }
        } else {
            $joke = 'Failed to fetch joke!';
        }

        $request->session()->put('joke', $joke);
        return redirect()->route('dashboard');
    }
}
