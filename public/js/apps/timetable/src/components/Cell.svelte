
<script>

	import {createEventDispatcher} from 'svelte';
	import {onMount, onDestroy} from 'svelte';

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
	export let rowSpan;

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
		appointment.time = appointment.start; // db constraint. fix later
		let id = -1;

		axios.post('/api/appointments/create', appointment)
			.then(response=>{
				id = response.data;
				appointment.id = id;
				empty = false;
				newAppointment = true;
				console.log('cell successfully recorded');
				dispatch('addAppointment', appointment);

				if (!appointment.user_id)
					return;

				let checkin = {
					user_id: appointment.user_id,
					shift_id: appointment.shift_id
				};
				axios.post('/api/checkins/create', checkin)
					.then(response=>console.log('checkin created'))
					.catch(err=>console.log(err));
			})
			.catch(err=>{
				alert('Алдаа гарлаа');
				console.log(err);
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
		axios.post('/api/appointments/cancel', d).then(response=>{
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
		axios.post('/api/users/create', user)
			.then(response=>{
				//user.id = response;
				appointment.registered = '1';
				registered = true;

				let checkin = {
					user_id: response,
					shift_id: appointment.shift_id
				};
				axios.post('/api/checkins/create', checkin)
					.then(response=>console.log('checkin created'))
					.catch(err=>console.log(err));
			})
			.catch(err=>{
				alert('Алдаа гарлаа');
				console.log(err);
			});
	}


let container = null;
onMount(()=>{
	container.style.height = `${rowSpan*10}vh`;
});

onDestroy(()=>appointment=null);

</script>

<div bind:this={container} 
	class="container grey" data-tooltip="English Literature"
	on:click={handleClick}>

	{#if appointment != null}
		<div class="content">
			{appointment.name} <br />
			{appointment.phone}
		</div>
		{:else}
		<div class="content"></div>
	{/if}
		<AppointmentModal
			bind:show={showAppointmentModal}
			on:submit={handleSubmit}
			on:openRegister={handleRegisterModal}
			on:delete={handleDelete}
			{shift}
			{time}
			doctor={shift.doctor}
			bind:appointment={appointment} />
		<RegisterModal
			bind:show={showRegisterModal} 
			on:submit={handleRegister}/>
</div>

<style type="text/css">

	.container {
	  z-index: 100;
	  width: 100%;
	  height: 100%;
	  transition: 0.4s;
	  border: 1px solid white;
	}

	.content{
		width: 100%; height: 100%;
		display: flex;
		flex-flow: column wrap;
		justify-content: center;
		align-items: center;
	}

	.disabled{
		background-color: grey;
		color: grey;
	}

	.newAppointment{

		color: #222222;
		background-color: #f2aa4fff;
	}

	.registered{
		color: white;
		background-color: green;
	}

	.class.short { height: 7.5vh; line-height: 7.5vh; } /* 45min class */
	.class.b15 { /* margin-top: 2.5vh;  */} /* after 15 min break */
	.class.b45 { /* margin-top: 7.5vh;  */} /* after 45 min break */
	.class.b90 { /* margin-top: 15vh;  */} /* after 2x45 min break */
	.class.b135 { /* margin-top: 22.5vh ;*/ } /* after 3x45 min break */

	.green { background-color: #2ecc71; }
	.turquoise { background-color: #1abc9c; }
	.navy { background-color: #34495e; }
	.blue { background-color: #3498db; }
	.purple { background-color: #9b59b6; }
	.grey { background-color: #bdc3c7; color: #202020; }
	.gray { background-color: #7f8c8d; }
	.red { background-color: #e74c3c; }
	.orange { background-color: #f39c12; }
	.yellow { background-color: #f1c40f; color: #303030; }

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