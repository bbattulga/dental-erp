
<script>

	import {createEventDispatcher} from 'svelte';

	import {fade} from 'svelte/transition';
	import {fly} from 'svelte/transition';
	import Modal from './modal/Modal.svelte';
	import AppointmentModal from './modal/AppointmentModal.svelte';
	import RegisterModal from './modal/RegisterModal.svelte';
	import SameUsersModal from './modal/SameUsersModal.svelte';
	import axios from 'axios';


	// dispatch events
	let dispatch = createEventDispatcher();

	export let shift;
	export let appointment;
	export let time;
	
	let sameUsers = [];
	
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
	let showSameUsersModal = false;

	// functions
	function handleClick(){
		if (disabled){
			return;
		}
		console.log('cell handle click');
		showAppointmentModal = true;
	}

	const findSameUsers = (data) => {
		let d = {name: data.name, phone: data.phone};
		return axios.post('/api/users/query', d);
	}

	const checkInUser = (userId, shiftId) => {
		let d = {
			user_id: userId,
			shift_id: shiftId
		}
		return axios.post('/api/checkins/create', d);
	}

	const handleAppointment = (event) => {
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
				if (appointment.user_id == 0){
					return;
				}
				checkInUser(appointment.user_id, appointment.shift_id)
					.then(response=>console.log('checkin added'))
					.catch(err=>console.log('couldnt create checkin'));
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

	const registerUser = (user) => {
		return axios.post('/api/users/create', user);
	}

	const handleRegister = (event) => {
		console.log('cell handle register');
		
		let user = event.detail.user;
		registerUser(user)
		.then(response=>{
			axios.put('/api/appointment/update', {user_id: response.data});
			user.id = response.data;
			appointment.registered = '1';
			registered = true;
			checkInUser(user.id, appointment.shift_id)
				.then(response=>console.log('created checkin'))
				.catch(err=>console.log('couldnt create checkin ',err));
		})
		.catch(err=>{
			alert('Алдаа гарлаа');
			console.log(err);
		})
	}

	const handleSubmitUser = (event) => {
		console.log('checkin existing', event.detail);
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
			<h5>{appointment.phone}</h5>
		{/if}
	</div>
	</div>
	
		<AppointmentModal
			bind:show={showAppointmentModal}
			on:submit={handleAppointment}
			on:openRegister={()=>showRegisterModal = true}
			on:delete={handleDelete}
			{shift}
			{time}
			doctor={shift.doctor}
			appointment={appointment} />

		<RegisterModal
			bind:show={showRegisterModal} 
			on:submit={handleRegister}/>

		<SameUsersModal
			bind:show={showSameUsersModal}
			on:submit={handleSubmitUser}
			bind:users = {sameUsers}/>
</td>


<style type="text/css">
	
	td{
		z-index: 1000;
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
		color: #222222;
		background-color: #f2aa4fff;
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