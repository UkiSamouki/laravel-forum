<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Replay as Reply;
use App\Inspections\Spam; 


class ReplayController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth', ['except' => 'index']);	
	}
	
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($chanelId ,Thread $thread, Spam $spam){

        $this->validate(request(), ['body' => 'required']);

        $spam->detect(request('body'));

    	$replay = $thread->addReplay([
    		'body' => request('body'),
    		'user_id' => auth()->id()
    	]);

        if (request()->expectsJson()) {
            
            return $replay->load('owner');
        }

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
