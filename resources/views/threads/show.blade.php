@extends('layouts.app')

@section('content')

<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>

<div class="container">
    <div class="row">
      <div class="col-md-8">
            <div class="card" style="margin-bottom: 80px;">
                <div class="card-body">
                  <div class="level">
                  <span class="flex">
               <h5><a href="/profiles/{{$thread->creator->name}}">
                {{ $thread->creator->name }}</a> posted:
                  {{ $thread->title }}
                </h5>
                </span>
                @can ('update', $thread)
                <form action="{{ $thread->path() }}" method="POST">
                  
                @csrf
                {{ method_field('DELETE') }}
                  
                  <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
                @endcan
                </div>
                <hr>
                     <div class="body">{{ $thread->body }}</div>
            </div>
          </div>
          
            <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>
          
            {{ $replies->links() }}
          @if (auth()->check())
          <form method="POST" action="{{ $thread->id."/replies" }}" style="padding-top: 30px;">
            @csrf
              <div class="form-group">
                
                <textarea name="body" id="body" class="form-control" placeholder="Have somthing to say?" rows="5">
                  
                </textarea>
              </div>

              <button type="submit" class="btn btn-primary">Post</button>
         </div>

        <div class="col-md-4">
          <div class="card" style="float: right;">
                <div class="card-header"><h5>Info about Thread
                </h5>
              </div>

                <div class="card-body">
                     <div class="body">
                  <p>This thraed is published {{ $thread->created_at->diffForHumans() }} <br>by 
                        <a href="">{{ $thread->creator->name }}</a> and curently has 
                        <span v-text="repliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}.
                  </p>
                  </div>
                </div>
            </div>
      


        </div>
    

          </form>
    @else

    <p class="text-center" style="padding-top: 20px;">Please 
      <a href="{{ route('login') }}">sign in</a>
     to participate in this discussion</p>

            @endif
          </div>
      </div>
    </div>
  </thread-view>
@endsection
