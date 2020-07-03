<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import {createEventDispatcher} from 'svelte';

	export let appointments;

	let times = [];
	for (let i=9; i<21; i++) times.push(""+i+":00");

	let dispatch = createEventDispatcher();


	appointments.forEach(appointment=>{

		appointment.times = [];
		
		times.forEach(time=>{
			let hasUser = false;
			let users = appointment.users;
			for (let i =0; i<users.length; i++){
				if (users[i].start == time){
					appointment.times.push({user: users[i]});
					hasUser = true;
					break;
				}
			}
			if (!hasUser)
				appointment.times.push(null);
		})
	});
	
	function handleCell(event){
		dispatch('queryCell', {user: event.detail.user});
	}
</script>


<table class="main-table">

	<!-- Title columns -->
	<tr class="header-row">
		<td></td>
		{#each times as time}
		<th>{time} цаг</th>
		{/each}
	</tr>

	{#each appointments as appointment}

	<tr>
		<td>{appointment.doctor_shift.doctor.name}</td>

		{#each appointment.times as time}
		{#if time != null}

			<Cell 
				on:click={handleCell}
				user={time.user} />

			{:else}
				<Cell 
					on:click={handleCell}
					user={null} />
		{/if}
		{/each}
	</tr>
	{/each}
</table>

<style>

	th{
		width: 200px;
	}

	td{
		width: 120px;
		height: 80px;
		padding: 10px;
		border-radius: 3px;
		background-color: white;
		margin: 10px;
	}

	.main-table{

		background-color: #e7e7e7e7;
		overflow: auto;
		border: 1px solid black;
	}

	.header-row{
		height: 100px;
		min-width: 100%;
		position: sticky;
		top: 0px;
		background-color: #abd6dfff;
	}
</style>