@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
       @forelse ($threads as $thread)
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                   <article>
                    <div class="level">
                       <h4 class="flex">
                       <a href="{{ $thread->path() }}">

                          @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))


                              <strong>

                              {{ $thread->title }}
                              
                              </strong>

                          @else

                              {{ $thread->title }}
  
                          @endif

                      </a>
                      </h4>
                      <a href="{{ $thread->path() }}">
                        {{ $thread->replies_count }} {{ str_plural('reply' , $thread->replies_count) }}
                      </a>
                    </div>
                    <hr>
                       <div class="body">{{ $thread->body }}</div>
                   </article>
                
                </div>
            </div>
            @empty
            <p>There are no relevant results at this time.</p>
      @endforelse
        </div>
    </div>
</div>
@endsection
