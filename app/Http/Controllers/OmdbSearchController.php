<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class OmdbSearchController extends Controller
{
    private $apikey ='e0f68d09';
    protected $UID;

    public function index()
    {
        $this->UID = auth()->user()->id;
        return Inertia::render('search');
    }

    public function create(Request $request)
    {
        $this->UID = auth()->user()->id;
        $id = $request->input('imdbID');

        $data = new Favorites([
            'UID' => $this->UID,
            'IMDbID' => $id,
        ]);
        //var_dump($data); die();
        $data->save();
        return response()->json(['message' => 'task was successful']);
    }

    public function searchMovies($str, $page)
    {
        $data = Http::get('http://www.omdbapi.com/?apikey='.$this->apikey.'&s='.$str.'&page='.$page)->json();
        $total = $data['totalResults'];
        $pages=ceil($total/10);
        $data['page']=$page;
        $data['pages']=$pages;
        return $data;
    }

    public function search(Request $request)
    {
        $url = explode('/', $request->url());
        $url[4]=str_replace('%20', ' ', $url[4]);
        $data = Http::get('http://www.omdbapi.com/?apikey='.$this->apikey.'&s='.$url[4].'&page='.$url[5])->json();
        //var_dump($data); die();
        if($data['totalResults']) {
            $total = $data['totalResults'];
            $pages = ceil($total / 10);
            $data['page'] = $url[5];
            $data['pages'] = $pages;
        } else {
            $data['trace']=$request->input();
            $data['error']='failed to sent data';
        }
        return $data;
    }


}

