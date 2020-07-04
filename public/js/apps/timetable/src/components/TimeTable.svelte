<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import {createEventDispatcher} from 'svelte';
	import Modal from './modal/Modal.svelte';
	import UserModal from './modal/UserModal.svelte';

	export let appointments;

	let currentDetail = null;
	let currentTime = null;

	let times = [];
	for (let i=9; i<21; i++) times.push(""+i+":00");

	let dispatch = createEventDispatcher();
	
	let showModal = false;

	// adds times array to appointments
	// details are passed to Cells as <Cell {user} {doctor {time}}/>

	let rows = [];
	let cells = [];

	appointments.forEach(appointment=>{

		appointment.cells = [];
		let row = [];
		let cells = [];

		times.forEach(time=>{
			let hasUser = false;
			let users = appointment.users;
			for (let i =0; i<users.length; i++){
				if (users[i].start == time){
					appointment.cells.push({user: users[i]});

					let cell = {
						user: users[i]
					}
					row.push(cell);
					hasUser = true;
					break;
				}
			}
			rows.push(row);
			if (!hasUser)
				appointment.cells.push({user:null});
		})
	});
	
	function handleCell(event){
		showModal = true;
		//dispatch('queryCell', {user: event.detail.user});
		//alert(JSON.stringify(event.detail.user));
		currentDetail = event.detail;
	}

	function handleSubmit(event){
		showModal = false;
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

		<!-- now each cell knows which doctor, which patient, which time
			and reports those details through on:click -->
		{#each appointment.cells as cell}
			<Cell 
				on:click={handleCell}
				user={cell.user} 
				doctor={appointment.doctor_shift.doctor}/>
		{/each}
	</tr>
	{/each}


	<Modal
		bind:showModal={showModal}>

		<UserModal 
			detail={currentDetail}
			on:submit={handleSubmit}/>
	</Modal>

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