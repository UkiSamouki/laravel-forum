<template>
	
	
	<div :id="'replay-'+id" class="card" style="margin-bottom:30px;">

   <div class="card-header">
   	<div class="level">
     <h6 class="flex">
     <a href="'/profiles/'+ data.owner.name" class="flex" v-text="data.owner.name"></a>
     &nbsp;  
      <span>said {{ data.created_at }}...</span>
  </h6>

      <div v-if="signIn"> 
    
        <favorite :replay="data"></favorite>
    
      </div>
   </div>
  </div>
  

    <div class="card-body">
      
      <div v-if="editing">

        <div class="form-group">  

          <textarea class="form-control" name="" id="" cols="80" rows="3" v-model="body"></textarea>
        
        </div>

        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs btn-link" @click="editing=false">Cancel</button> 
      </div>

            <div v-else v-text="body"></div>
 	 </div>

    <!--@can ('update', $replay) -->

    <div class="card-footer level" v-if="canUpdate">
      
      
      <button class="btn btn-xs mr-4" style='border: 1px solid grey;' @click="editing=true">Edit</button>

      <button class="btn btn-xs mr-4 btn-danger" style='border: 1px solid grey;' @click="destroy">Delete</button>

    </div>
    <!--@endcan -->
                   
</div>

</template>



<script>

import Favorite from './Favorite.vue';
	
export default {

	props:['data'],

	components: { Favorite },

	data() {

		return {

			editing:false,
			id: this.data.id,
			body:this.data.body
		};
	},

	computed: {

		signIn(){

			return window.App.signIn;
		},

		canUpdate(){

			return this.authorize(user=> this.data.user_id == user.id);
		}
	},

	methods: {

		update(){

			axios.patch('/replies/' + this.data.id, {

				body: this.body
			});

			this.editing = false;
			flash('Updated');
		},
		destroy(){

			axios.delete('/replies/' + this.data.id);
			
			this.$emit('deleted', this.data.id);
			/*
			$(this.$el).fadeOut(300, ()=>{

				flash('Deleted');

			});*/

		}

	}
};


</script>