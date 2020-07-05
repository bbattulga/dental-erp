<script>
	export let name;
	import TimeTable from './components/TimeTable.svelte';
	import axios from 'axios';

	let shifts = [];

		axios.post('/reception/time/appointments')
			.then(response=>{
				console.log('appointments from server');
				let sdata = response.data;
				console.log(sdata);
				shifts = sdata;
			}).catch(err=>{
				console.log(err);
			});

		let times = [];
		for (let i=9; i<21; i++) times.push(""+i+":00");

		let title = "table title";

	</script>

	<main>
		<h1>{title}</h1>
		<TimeTable 
			{shifts}
			{times} />
	</main>

	<style>
		main {
			background-color: white;
			overflow: auto;
			width: 100%;
		}

		h1 {
			color: #ff3e00;
			text-transform: uppercase;
			font-size: 1.2em;
			font-weight: 100;
		}

		@media (min-width: 640px) {
			main {
				max-width: none;
			}
		}
	</style>