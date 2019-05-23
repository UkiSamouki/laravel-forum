@extends('layouts.app')

@section('content')
<div class="container">
		<div class="page-header">
		<h1>{{ $profileUser->name }} &nbsp;
		<small> Since {{ $profileUser->created_at->diffForHumans() }}</small>
		</h1>
	</div>
  <br>
	@forelse($activities as $date => $activity)
    <h3 class="page-header">{{ $date }}</h3>
      @foreach($activity as $record)
      	@if(view()->exists("profiles.activities.{$record->type}"))
	       @include ("profiles.activities.{$record->type}", ['activity' => $record])
	       @endif
	@endforeach

		@empty
     		<p>There is no activity for this user yet.</p>
      @endforelse
</div>
 @endsection