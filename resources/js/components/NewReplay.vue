<template>

	<div>

		<div v-if="signedIn">
              <div class="form-group">
                
                <textarea  class="form-control" 
                name="body" id="body" 
                placeholder="Have somthing to say?" 
                v-model="body" rows="5" required>
                  
                </textarea>
              </div>
                  <button type="submit" class="btn btn-primary" @click="addReplay">Post</button>
           </div>

           <p class="text-center" v-else>
           		
				Please <a href="/login">sign in</a> to participate in this discussion
           </p>
	</div>
</template>		

<script>
	
	export default {

			props:['endpoint'],

			data(){

				return {

					body: ""
				};
			},

			computed: {

					signedIn(){

						return window.App.signIn;
					}

			},
			methods: {

				addReplay() {

				axios.post(this.endpoint, { body: this.body })
				.then(response => {

					this.body = '';

					flash('Your replay has been posted.');

					this.$emit('created', response.data);
				});
			}
		}
	}

</script>