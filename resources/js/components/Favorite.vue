<template>
	
	<div class="fav-border">
		<button type="submit" :class="classes" @click="toggle">
			
		<img src="https://img.icons8.com/office/16/000000/hearts.png">
	   			
	   			<span v-text="count"></span>
	  </button>

  </div>
   	</form>

</template>

<script>
	
	export default {

			data(){

				return {

					count: this.replay.favoritesCount,
					active: this.replay.isFavorited
				}
			},

			props: ['replay'],

			computed: {

				  classes() {

				  		return ['btn' , this.active ? 'btn-primary' : 'btn-default'];
				  },

				  endpoint() {

				  		return '/replies/'+ this.replay.id +'/favorites';
				  }
			},

			methods: {

				toggle() {

					 this.active ? this.destroy() : this.create();
				},

				destroy() {

						axios.delete(this.endpoint);

						this.active = false;

						this.count--;

				},

				create() {

						axios.post(this.endpoint);

						this.active = true;

						this.count++;

				}

			}
	};

</script>

<style>
	
 .fav-border {

 	border: 0.5px solid #6c757d;
 }

</style>