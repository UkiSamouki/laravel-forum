<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Replay;
use App\Favorite;




class FavoritesController extends Controller
{
    

    function __construct()
    {
    	$this->middleware('auth');
    }

    public function store(Replay $replay)
    {

    	 $replay->favorite();

    	 return back();
    }
    public function destroy(Replay $replay)
    {
    	$replay->unfavorite();
    }
}
