@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create new Thread</div>
                <div class="card-body">
       <form method="POST" action="/threads">
        @csrf
        <div class="form-group">
            <label for="chanel_id">Choose a Channel:</label>
            <select name="chanel_id" id="chanel_id" class="form-control" required>
              <option value="">Choose One...</option>
              @foreach ($chanels as $channel)
                <option value="{{ $channel->id }}" {{ old('chanel_id') == $channel->id ? 'selected' : '' }}>
                  {{ $channel->name }}
                </option>
              @endforeach

            </select>
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input name="title" type="text" class="form-control" 
            placeholder="title" value="{{ old('title') }}"required>
          </div>      
          <div class="form-group">
              <label for="Body">Body</label>
              <textarea name="body" class="form-control" id="body" 
              rows="5" placeholder="Content" value="{{ old('body') }}" required>
                
              </textarea>
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary">Publish</button>
            </div>
        @if (count($errors))
          <ul class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
          @endif
        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
