<template>
	
 <div>
 	
	<div v-for="(replay,index) in items">
		
		<replay :data="replay" @deleted="remove(index)"></replay>
	</div>

 </div>

</template>

<script>
	
	import Replay from './Replay.vue';
	

	export default {

		props: ['data'],

		components: { Replay },

		data(){

			return {

				items: this.data
			}
		},

		methods: {

			remove(index){

				this.items.splice(index, 1);

				this.$emit('removed');

				flash('Replay was deleted');
			}
		}
	}

</script>