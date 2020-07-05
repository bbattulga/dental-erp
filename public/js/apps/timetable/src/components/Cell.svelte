
<script>

	import {createEventDispatcher} from 'svelte';

	import Modal from './modal/Modal.svelte';
	import AppointmentModal from './form/AppointmentModal.svelte';
	import axios from 'axios';


	// dispatch events
	let dispatch = createEventDispatcher();

	export let shift;
	export let appointment;
	export let time;


	// conditional classes
	let empty =  appointment == null;
	let newAppointment = !empty && (appointment.user_id == "0");
	let registered = !empty && (appointment.user_id != "0");

	// values
	let colSpan = empty? 1: appointment.end-appointment.start;

	// flags
	let showModal = false;

	// functions
	function handleClick(){
		showModal = true;
	}

	const handleSubmit = (event)=>{
		console.log('cell handle submit');
		console.log(event.detail);

		let appointment = event.detail.appointment;

		let id = -1;
		axios.post('/reception/time/add', appointment)
			.then(response=>{
				id = response.data;
				appointment.id = id;
				empty = false;
				newAppointment = true;
				dispatch('addAppointment', appointment);
			})
			.catch(err=>console.log(err));
	}

	const handleDelete = (event)=>{
		let appointment = event.detail;
		let count = 0;
		console.log('cell got appointment ', appointment);
		let d = {
			appointment_id: appointment.id,
			code: '1111',
			description: 'test'
		}
		console.log('sent like ', d);
		axios.post('/reception/time/cancel', d).then(response=>{
			count = response.data;
			console.log(response);
		}).catch(err=>console.log(err));
		dispatch('deleteAppointment', appointment.id);
	}

</script>


<td colspan={colSpan} 
	on:click={handleClick}>
	<div class="u"
	class:registered={registered}
	class:empty={empty}
	class:newAppointment={newAppointment}>
		{#if appointment == null}
			<h4>Цаг захиалах</h4>
		{:else}
			<p>{appointment.name}</p>
			<p>{appointment.phone}</p>
		{/if}
	</div>
		<AppointmentModal
			bind:show={showModal}
			on:submit={handleSubmit}
			on:delete={handleDelete}
			{shift}
			{time}
			doctor={shift.doctor}
			appointment={appointment} />
</td>


<style type="text/css">
	
	td{
		width: 80px;
		transition: 0.3s;
		border: 3px solid #cccccc;
	}

	.u{
		cursor: pointer;
		background-color: #333333;
		margin: 5px;
		padding: 2px;
		border-radius: 10px;
	}

	td:hover .u{
		background-color: #f05e30;
	}

	.empty{
		visibility: hidden;
	}

	td:hover .empty{
		visibility: visible;
		background-color: grey;
		color: white;
		display: block;
		cursor:pointer;

		-webkit-animation: fadein 0.7s; /* Safari, Chrome and Opera > 12.1 */
		-moz-animation: fadein 0.7s; /* Firefox < 16 */
		-ms-animation: fadein 0.7s; /* Internet Explorer */
		-o-animation: fadein 0.7s; /* Opera < 12.1 */
		animation: fadein 0.7s;
	}

	.newAppointment{
		color: white;
		background-color: #f05e23;
	}

	.registered{
		color: white;
		background-color: green;
	}

	.newAppointment:hover{
		color: white;
		background-color: #f05e23;
	}

	.registered:hover{
		background-color: green;
	}

	@keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Firefox < 16 */
	@-moz-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Safari, Chrome and Opera > 12.1 */
	@-webkit-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Internet Explorer */
	@-ms-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Opera < 12.1 */
	@-o-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

</style>