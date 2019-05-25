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
          
            <replies  @added="repliesCount++" @removed="repliesCount--"></replies>

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
          </div>
      </div>
    </div>
  </thread-view>
@endsection
