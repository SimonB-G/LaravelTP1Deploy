<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Http\Resources\FilmCriticResource;
use App\Http\Resources\FilmResource;
use App\Http\Resources\FilmActorsResource;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $keywords = '%'.$keywords.'%';
        $rating = $request->input('rating', '%');
        $maxlength = $request->input('max-length', 1400);

        return Film::where('rating', 'like', $rating)
                    ->where('length', '<', $maxlength)
                    ->where(function ($query) use ($keywords) {
                        $query->where('title', 'like', $keywords)
                              ->orwhere('description', 'like', $keywords);
                    })
                    ->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $film = Film::create($request->all());

        return (new FilmResource($film))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new FilmCriticResource(Film::findOrFail($id));
    }

    public function showActors($id)
    {
        return new FilmActorsResource(Film::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
     

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Film::destroy($id);
    }
}
