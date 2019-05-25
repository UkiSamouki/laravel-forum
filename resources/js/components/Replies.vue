<template>
	
 <div>
 	
	<div v-for="(replay,index) in items" :key="replay.id">
		
		<replay :data="replay" @deleted="remove(index)"></replay>
	</div>
	
	<paginator :dataSet="dataSet" @changed="fetch"></paginator>	

	<new-replay :endpoint="endpoint" @created="add"></new-replay>

 </div>

</template>

<script>
	
	import Replay from './Replay.vue';
	import NewReplay from './NewReplay.vue';

	

	export default {


		components: { Replay, NewReplay },

		data(){

			return {

				dataSet: false,
				items: [],
				endpoint: location.pathname + '/replies'
			}
		},

		created() {

			this.fetch();
		},

		methods: {

			fetch(page){

				axios.get(this.url(page))
					.then(this.refresh);
			},

			refresh({data}){

				this.dataSet = data;
				this.items = data.data;

				window.scrollTo(0, 0);

			},

			url(page) {

				if (! page) {

					let query = location.search.match(/page=(\d+)/);

					page = query ? query[1] : 1;
				}
				return `${location.pathname}/replies?page=` + page;
			},

			remove(index){

				this.items.splice(index, 1);

				this.$emit('removed');

				flash('Replay was deleted');
			},

			add(replay){

				this.items.push(replay);

				this.$emit('added');

			}
		}
	}

</script>