
<script>

	import {createEventDispatcher} from 'svelte';

	import {fade} from 'svelte/transition';
	import {fly} from 'svelte/transition';
	import Modal from './modal/Modal.svelte';
	import AppointmentModal from './modal/AppointmentModal.svelte';
	import RegisterModal from './modal/RegisterModal.svelte';
	import axios from 'axios';


	// dispatch events
	let dispatch = createEventDispatcher();

	export let shift;
	export let appointment;
	export let time;
	let disabled = false;
	let shift_type = shift.shift_type_id;
	if ((shift_type == 1) && (time >= '15:00')){
		disabled = true;
	}else if ((shift_type == 2) && (time < '15:00')){
		disabled = true;
	}

	// conditional classes
	let empty =  (appointment == null) && !disabled;
	let newAppointment = !empty && !disabled && (appointment.user_id == "0");
	let registered = !empty && !disabled && (appointment.user_id != "0");

	// values
	let colSpan = (appointment==null)? 1: appointment.end-appointment.start;

	// flags
	let showAppointmentModal = false;
	let showRegisterModal = false;

	// functions
	function handleClick(){
		if (disabled){
			return;
		}
		console.log('cell handle click');
		showAppointmentModal = true;
	}

	const handleSubmit = (event) => {
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
			.catch(err=>{
				alert('Алдаа гарлаа');
			});
	}

	const handleDelete = (event) => {
		let appointment = event.detail;
		if (appointment.code != '1111'){
			alert('Код буруу байна');
			return;
		}

		let count = 0;
		console.log('cell got appointment ', appointment);
		let d = {
			appointment_id: appointment.id,
			code: appointment.code,
			description: 'test'
		}
		console.log('sent like ', d);
		axios.post('/reception/time/cancel', d).then(response=>{
			count = response.data;
			console.log(response);
		}).catch(err=>console.log(err));
		dispatch('deleteAppointment', appointment.id);
	}

	const handleRegisterModal = (event) => {
		console.log('cell show registermodal');
		showRegisterModal = true;
	}

	const handleRegister = (event) => {
		console.log('cell handle register');
		
		let user = event.detail.user;
	/*	let dummy = {
			last_name: 'dummylastname',
	         name: 'dummyname',
	         sex: 1,
	         register: 'ИР89382716',
	         phone_number: '89382716',
	         email: 'joonjiinaze@mail.com',
	         birth_date: '2000-02-02',
	         location: 'zaisan',
	         info: 'nodescription'
		} */
		user.appointment_id = appointment.id;
		console.log('sent like ', user);
		axios.post('/reception/user/store', user)
			.then(response=>{
				//user.id = response;
				appointment.registered = '1';
				registered = true;
			})
			.catch(err=>{
				alert('Алдаа гарлаа');
				console.log(err);
			})
	}

</script>


<td transition:fade
	colspan={colSpan} 
	on:click={handleClick}
	class:disabled = {disabled}>
	<div class="u"
	class:registered={registered}
	class:empty={empty}
	class:newAppointment={newAppointment}>
	<div style="display: inline-block;">
		{#if appointment == null}
			<h4>{disabled? '':'Цаг захиалах'}</h4>
		{:else}
			<h4>{appointment.name}</h4>
			<p>{appointment.phone}</p>
		{/if}
	</div>
	</div>
		<AppointmentModal
			bind:show={showAppointmentModal}
			on:submit={handleSubmit}
			on:openRegister={handleRegisterModal}
			on:delete={handleDelete}
			{shift}
			{time}
			doctor={shift.doctor}
			appointment={appointment} />
		<RegisterModal
			bind:show={showRegisterModal} 
			on:submit={handleRegister}/>
</td>


<style type="text/css">
	
	td{
		transition: 0.4s;
		border: 3px solid #cccccc;
		height: 100%;
	}

	.disabled{
		background-color: grey;
		color: grey;
	}

	.u{
		z-index: 1;
		position: relative;

		cursor: pointer;
		margin: 5px;
		border-radius: 10px;

		display: block;
		height: 80%;
	}

	.u > div{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}

	td:hover .u{

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
		font-size: 1.5em;
		color: white;
		background-color: #4a4c4c;
	}

	.registered{
		color: white;
		background-color: green;
	}

	.newAppointment:hover{

	}

	.registered:hover{

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