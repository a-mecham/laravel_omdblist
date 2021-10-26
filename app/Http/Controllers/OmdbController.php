<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class OmdbController extends Controller
{
    private $apikey ='e0f68d09';
    protected $UID;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->UID = auth()->user()->id;
        $data = Favorites::all()->where('UID','=', $this->UID);
        $out = array();
        foreach ($data as $entry){
            array_push($out, $this->show($entry['IMDbID']));
        }

        return Inertia::render('favorites', ['data' => $out]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = new Favorites([
            'UID' => $this->UID,
            'IMDbID' => $request->input('IMDbID')
        ]);
        $data->save();
        return redirect()->back();//->with('message', 'Entry added to Favorites Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favorites  $favorites
     * @return \Illuminate\Http\Response
     */
    public function show($imdbid)
    {
        $data = Favorites::find($imdbid);
        $out = Http::get('http://www.omdbapi.com/?apikey='.$this->apikey.'&i='.$imdbid);
        //var_dump($out->json());
        return $out->json();

        //return Inertia::render('favorites/search', ['data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorites  $favorites
     * @return \Illuminate\Http\Response
     */
    public function destroy($imdbid)
    {
        $data = Favorites::find($this->UID, $imdbid);
        $data->delete();
        return redirect()->back();
    }

    public function searchMovies($str, $page)
    {
        $data = Http::get('http://www.omdbapi.com/?apikey='.$this->apikey.'&s='.$str.'&page='.$page)->json();
        $total = $data['totalResults'];
        $pages=ceil($total/10);
        $data['page']=$page;
        $data['pages']=$pages;
        //var_dump($data->json());

        return $data;
    }


}
