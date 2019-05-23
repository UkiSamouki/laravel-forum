<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Replay as Reply;

class ReplayController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');	
	}
	
    public function store($chanelId ,Thread $thread){

        $this->validate(request(), [
            'body' => 'required'
        ]);

    	$thread->addReplay([
    		'body' => request('body'),
    		'user_id' => auth()->id()
    	]);

    	return back()->with('flash', 'Your reply has been created');
    }
    public function destroy(Reply $replay)
    {   


        $this->authorize('update', $replay);

        $replay->delete();

        if (request()->expectsJson()) {
            
            return response(['status' => "Reply deleted"]);
        }


        return back();       
    }

    public function update(\App\Replay $replay)
    {
        
        $this->authorize('update', $replay);


        $replay->update(['body' => request('body')]);
    }
}
