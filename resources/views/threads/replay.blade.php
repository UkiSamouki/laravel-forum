
<replay :attributes="{{ $replay }}" inline-template v-cloak>
<div id="reply-{{ $replay->id }}" class="card" style="margin-bottom:30px;">

   <div class="card-header">
   	<div class="level">
     <h6 class="flex">
     <a href="/profiles/{{$replay->owner->name}}" class="flex">{{ $replay->owner->name }}</a>
     &nbsp;  
      <span> {{ $replay->created_at->diffForHumans() }}...</span>
  </h6>
    @if (Auth::check())
      <div> 

        <favorite :replay="{{ $replay }}"></favorite>
    
      </div>
      @endif
  	</div>
  </div>
  

    <div class="card-body">
      
      <div v-if="editing">

        <div class="form-group">  

          <textarea class="form-control" name="" id="" cols="80" rows="3" v-model="body">{{ $replay->body }}</textarea>
        
        </div>

        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs btn-link" @click="editing=false">Cancel</button> 
      </div>

            <div v-else v-text="body"></div>
 	 </div>

    @can ('update', $replay)

    <div class="card-footer level">
      
      
      <button class="btn btn-xs mr-4" style='border: 1px solid grey;' @click="editing=true">Edit</button>

      <button class="btn btn-xs mr-4 btn-danger" style='border: 1px solid grey;' @click="destroy">Delete</button>

      
      <!-- <form method="POST" action="/replies/{{ $replay->id }}">
          
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      
      
      <button type="submit" class="btn btn-danger btn-xs">Delete</button>
      
      </form> -->
    </div>
    @endcan
                   
</div>

</replay>