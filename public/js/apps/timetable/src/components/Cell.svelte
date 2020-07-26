
<script>

	import {createEventDispatcher} from 'svelte';
	import {onMount, onDestroy} from 'svelte';
	import {fade} from 'svelte/transition';
	import {fly} from 'svelte/transition';
	import {setContext} from 'svelte';
	import Modal from './modal/Modal.svelte';
	import axios from 'axios';

	import AppointmentModal from './modal/AppointmentModal.svelte';
	import RegisterModal from './modal/RegisterModal.svelte';
	import CheckInModal from './modal/CheckInModal.svelte';
	import {storeSearch, storeUserBaseData} from '../stores/stores.js';


	// dispatch events
	let dispatch = createEventDispatcher();

	export let shift;
	export let appointment;
	export let time;
	export let rowSpan;
	export let width;

	// this will be used when submitting checkin from list of registered users
	let registeredAppointment = {
		shift_id: shift.id,
		name: '',
		phone: '',
		start: !appointment? '':appointment.start,
		end: !appointment? '':appointment.end,
		time
	}

	let disabled = false;
	let shift_type = shift.shift_type_id;
	if ((shift_type == 1) && (time >= 15)){
		disabled = true;
	}else if ((shift_type == 2) && (time < 15)){
		disabled = true;
	}

	// conditional classes
	let empty =  (appointment == null) && !disabled;
	let notregistered = !empty && !disabled && (appointment.user_id == 0);
	let registered = !empty && !disabled && (appointment.user_id != 0);

	let match = null;
	let nomatch = false;
	let keyword = null;
	const unsubscribeSearch = storeSearch.subscribe(val=>keyword=val);
	$:{

		if (keyword == null){
			match = false;
			nomatch = false;
		}
		else if (appointment){

			let regex = new RegExp(keyword, 'i');
			if (regex.exec(appointment.name) || regex.exec(appointment.phone)){
				match = true;
				nomatch = false;
			}else{
				match = false;
				nomatch = true;
			}
		}
	}

	// flags
	let showAppointmentModal = false;
	let showRegisterModal = false;
	let registerModalInitialData = null;
	let showCheckInModal = false;

	let initialDataElem = document.getElementById('cell-user-data');

	// functions
	const  handleClick = (event) => {
		if (disabled){
			return;
		}
		console.log('cell handle click');
		console.log('inital data:');
		console.log(initialDataElem);
		if (initialDataElem){
			let user = JSON.parse(initialDataElem.value);
			console.log('parsed user');
			console.log(user);
			registeredAppointment.name = user.name;
			registeredAppointment.phone = user.phone_number;
			registeredAppointment.user = user;
			registeredAppointment.user_id = user.id;
			registeredAppointment = registeredAppointment;
			showCheckInModal = true;
		}else{
			showAppointmentModal = true;
		}
	}

	const handleSubmit = (event) => {
		console.log('cell handle submit');
		console.log(event.detail);

		let appointment = event.detail.appointment;
		appointment.time = appointment.start; // db constraint. fix later
		let id = -1;
		console.log('cell handling appointment');
		console.log(appointment);
		axios.post('/api/appointments/create', appointment)
			.then(response=>{
				id = response.data;
				appointment.id = id;
				empty = false;
				notregistered = true;
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
			shift_id: appointment.shift_id,
			user_id: appointment.user_id,
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
		registerModalInitialData = event.detail;
		showAppointmentModal = false;
		showCheckInModal = false;
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
				let user = response.data;
				console.log('created user');
				console.log(user);
				//user.id = response;
				appointment.user_id = user.id;
				appointment.registered = '1';
				registered = true;
				axios.put('/api/appointments/update', {id: appointment.id, user_id: user.id});

				let checkin = {
					user_id: user.id,
					shift_id: appointment.shift_id
				};
				console.log('sent checkin');
				console.log('checkin');
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
	// container.style.width = width;
	container.style.height = `${rowSpan*4}vh`;
});

onDestroy(()=>{
	unsubscribeSearch();
});

</script>

<div bind:this={container} 
class:disabled={disabled}
	class="cell-container grey"
	on:click={handleClick}>

	{#if appointment != null}

		<!-- content -->
		<div class="content"
			class:notregistered
			class:registered
			class:match
			class:nomatch>
			<label style="text-align: center;">{registered? appointment.user.last_name.charAt(0)+'. '+appointment.user.name: appointment.name}</label>
			<label>{appointment.phone}</label>
		</div>

		<!-- appointment==null -->
		{:else}
		<div class="content empty">
			{#if disabled}
				Эмчийн цаг биш
				{:else}
				Цаг захиалах <br />
				<h8>{time.str}</h8>
			{/if}
		</div> <!-- content end -->
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
			initialData={registerModalInitialData}
			bind:show={showRegisterModal} 
			on:submit={handleRegister}/>

		<CheckInModal
			on:submit={handleSubmit}
			{shift}
			appointment={registeredAppointment}
			{time}
			bind:show={showCheckInModal}
			on:submit={handleSubmit} />
</div>

<style type="text/css">

	.cell-container {
	  width: 100%;
	  height: 100%;
	  border: 1px solid #e0e0e0e0;
	  padding: 0;
	  color: #333333;
	  position: relative;
	}
	div:hover{
		transition: 0.4s;
	}

	div:hover .content{
		transition: 0.4s;
		background-color: #efefefef;
		color: #363636;
		cursor: pointer;
	}
	div:hover .content *{
		cursor: pointer;
	}
	.content{
		width: 100%; 
		height: 100%;
		display: flex;
		flex-flow: column wrap;
		justify-content: center;
		align-items: center;
		color: #332222;
	}

	.empty{
		color: #bdc3c7;
		background: #bdc3c7;
	}

	div:hover .empty{
		color: #444444;
		background-color: #e0e0e0e0;
	}

	.notregistered{
		color: white;
		background-color: #eb2a7e;
	}

	.registered{
		color: #2a2a2a;
		background-color: #7eeb2a;
	}

	.match{

	}

	.nomatch{
		background-color: rgba(0, 0, 0, 0.5);
		color: #444444;
	}

	.disabled .content{
		color: #efefefef;
		background-color: #efefefef;
	}

	.disabled:hover .empty{
		color: #aaaaaa;
		background-color: #efefefef;
		cursor: default;
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