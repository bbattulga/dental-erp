<script>
	export let name;
	import TimeTable from './components/TimeTable.svelte';

	let customers = [

		{id: 1, name: 'name', lastName: 'lastname'}
	];

	let doctors = [
		{id: 1, name:'doctor1'},
		{id: 2, name: 'doctor2'}
	];

	let times = [];
	for (let i=9; i<20; i++) times.push(i);
</script>

<main>

	<TimeTable 
		doctors={doctors}
		customers={customers}
		times={times} />
	
</main>

<style>
	main {
		position: inherit;
		width: inherit;
		height: inherit;
		overflow: auto;
		text-align: center;
		padding: 20px;
		max-width: 240px;
		margin: 0 auto;
	}

	h1 {
		color: #ff3e00;
		text-transform: uppercase;
		font-size: 4em;
		font-weight: 100;
	}

	@media (min-width: 640px) {
		main {
			max-width: none;
		}
	}
</style>