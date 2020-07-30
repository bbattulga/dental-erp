
<script>

	import {createEventDispatcher} from 'svelte';
	import {onMount, onDestroy} from 'svelte';
	import {fade} from 'svelte/transition';
	import {fly} from 'svelte/transition';
	import Modal from './modal/Modal.svelte';
	import axios from 'axios';

	import AppointmentModal from './modal/AppointmentModal.svelte';
	import RegisterModal from './modal/RegisterModal.svelte';
	import CheckInModal from './modal/CheckInModal.svelte';
	import SameUsersModal from './modal/SameUsersModal.svelte';
	import {storeSearch, storeUserBaseData} from '../stores/stores.js';
	import {floatToTime, timeToFloat} from '../lib/datetime.js';
	import CheckInState from './CheckInState.svelte';

	// dispatch events
	let dispatch = createEventDispatcher();

	export let index;
	export let shift;
	export let appointment;
	export let nodes;
	export let time;
	export let rowSpan;
	export let width;

	let dragEnd = false;

	let sameUsers = [];	

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
	if ((shift_type == 1) && (time.float >= 15)){
		disabled = true;
	}else if ((shift_type == 2) && (time.float < 15)){
		disabled = true;
	}

	// conditional classes
	let empty =  (appointment == null) && !disabled;
	let notregistered = !empty && !disabled && (appointment.user_id == 0);
	let registered = !empty && !disabled && (appointment.user_id != 0);
	let checkin = null;
	$: checkin = appointment == null ? null:appointment.checkin;

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
	let showSameUsersModal = false;


	const findSameUsers = (name, phone) => {
		return axios.post('/api/patients/query', {name, phone});
	}

	// functions
	const  handleClick = (event) => {
		console.log('cell handle click');
		if (disabled){
			return;
		}
			showAppointmentModal = true;
	}

	const handleSubmit = (event) => {
		console.log('cell handle submit');
		console.log(event.detail);

		let appointment = event.detail.appointment;
		appointment.time = appointment.start; // db constraint. fix later
		let id = -1;
		console.log('cell appointment submitting');
		console.log(appointment);
		axios.post('/api/appointments/create', appointment)
			.then(response=>{
				console.log('appointment created')
				console.log(response.data);
				id = response.data.id;
				appointment.id = id;
				empty = false;
				console.log('cell successfully recorded');
				dispatch('addAppointment', appointment);

				if (!appointment.user_id){
					notregistered = true;
					return;
				}

				let checkin = {
					appointment_id: appointment.id,
					user_id: appointment.user_id,
					shift_id: appointment.shift_id
				};
				axios.post('/api/checkins/create', checkin)
					.then(response=>{
						console.log('checkin created')
						let checkin = response.data;
						// clone appointment
						appointment.checkin_id = checkin.id;
						appointment.checkin = checkin;
					})
					.catch(err=>console.log(err));
			})
			.catch(err=>{
				alert('Алдаа гарлаа');
				console.log(err);
			});
	}

	const handleSubmitUser = (event) => {
		let detail = event.detail;
		appointment.user = detail.user;
		appointment.user_id = detail.user.id;

		axios.put('/api/appointments/update', appointment)
			.then(response=>{
				notregistered = false;
				registered = true;
				appointment = appointment;

				// create checkin
				let data = {
					appointment_id: appointment.id,
					user_id: appointment.user_id,
					shift_id: appointment.shift_id
				};
				axios.post('/api/checkins/create', data)
					.then(response=>{
						let checkin = response.data;
						appointment.checkin_id = checkin.id;
						appointment.checkin = checkin;
					})
					.catch(err=>{
						alert('Алдаа гарлаа')
						console.log(err);
						appointment.user = null;
						appointment.user_id = 0;
					});
					})
			.catch(err=>console.log(err));
	}

	const handleCancelSameUsers = (event) => {
		sameUsers = [];
		showRegisterModal = true;
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
			dispatch('deleteAppointment', appointment.id);
			if (!appointment.checkin){
				return;
			}
		}).catch(err=>{
			console.log(err);
			alert('Алдаа гарлаа')
		});
	}

	const handleRegisterModal = (event) => {

		showAppointmentModal = false;
		showCheckInModal = false;

		let detail = event.detail;
		let name = detail.name;
		let phone = detail.phone;

		console.log('query user');
		console.log(name, phone);
		findSameUsers(name, phone)
			.then(response=>{
				console.log('same users');
				console.log(response.data);
				if (response.data.length > 0){
					sameUsers = response.data;
					showRegisterModal = false;
					showSameUsersModal = true;
					return;
				}
				// new user
				showRegisterModal = true;
			})
			.catch(err=>{
				alert('Төстай хаягуудыг олоход алдаа гарлаа');
			})
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
				appointment.user = user;
				appointment.registered = '1';
				registered = true;
				axios.put('/api/appointments/update', {id: appointment.id, user_id: user.id});

				let checkin = {
					appointment_id: appointment.id,
					user_id: user.id,
					shift_id: appointment.shift_id
				};
				console.log('sent checkin');
				console.log('checkin');
				axios.post('/api/checkins/create', checkin)
					.then(response=>{
						let checkin = response.data;
						appointment.checkin_id = checkin.id;
						appointment.checkin = checkin;
						console.log('checkin created');
						console.log(appointment.checkin);
					})
					.catch(err=>console.log(err));
			})
			.catch(err=>{
				alert('Алдаа гарлаа');
				console.log(err);
			});
	}

	const handleChangeTime = (event) => {

		let prevStart = appointment.start;
		let prevEnd = appointment.end;

		let start = event.detail.start;
		let end = event.detail.end;

		console.log('cell handle change time');
		console.log(start, end);
		// validation
		for (let i=0; i<nodes.length; i++){
			let next = nodes[i];
			if (!next.appointment){
				continue;
			}
			if(end > next.appointment.start ||
				(start < next.appointment.end)){
				let nextAppoitment = next.appointment;
				alert('Өөр үйлчлүүлэгчийн цагтай давхцаж байна');
				appointment.start = prevStart;
				appointment.end = prevEnd;
				return;
			}
		}

		appointment.start = start;
		appointment.end = end;
		updateAppointment(appointment)
			.then(response=>{
				dispatch('forceRefresh');
				let hours = timeToFloat(appointment.end)-timeToFloat(appointment.start);

				height = `${hours*2*4}vh`;
				container.style.height = height;
			})
			.catch(err=>{
				alert('Алдаа гарлаа')
				appointment.start = prevStart;
				appointment.end = prevEnd;
			})
			.finally(()=>{
				appointment=appointment;
				console.log('finally');
			})
	}

let deltaY = 0;
let prevY = null;
let y = null;
let prevAppointment = null;
let top = false;
let dragging = false;
const handleMouseMove = (event) => {
	dragging = true;
	if (!appointment)
		return;
	dragEnd = false;
	y = event.clientY;
	deltaY = prevY - event.clientY;
	if (deltaY > 20){
		deltaY = 0;
		prevY = y;

		let start = timeToFloat(appointment.start);
		if (index>1 && nodes[index-1].appointment &&
		 nodes[index-1].appointment.end < start){
			return;
		}
		let end = timeToFloat(appointment.end);

		if (end - start <= 0.5){
			handleStopResize(event);
			return;
		}
		if (top){
			if (index>0 && nodes[index-1].appointment && 
				(floatToTime(start) <= nodes[index-1].appointment.end)){
				return;
			}
			
			if (start >= 9.5){
				start -= 0.5;
				end -= 0.5;
			}
		}else{
			end -= 0.5;
			rowSpan -= 1;
			height = `${rowSpan*4}vh`
		}
		
		appointment.start = floatToTime(start);
		appointment.end = floatToTime(end);
		dispatch('forceRefresh');
		container.style.height = height;
	}else if (deltaY < -24){
		if (index+1 >= nodes.length)
			return;
		deltaY = 0;
		prevY = y;

		let start = timeToFloat(appointment.start);
		let end = timeToFloat(appointment.end);
		if (top){
			start += 0.5;
			end += 0.5;
			dispatch('forceRefresh');
		}else{
			end += 0.5;
			rowSpan += 1;
			height = `${rowSpan*4}vh`
		}
		if ((index<nodes.length) &&
			nodes[index+1].appointment && floatToTime(end) >= nodes[index+1].appointment.start){
			return;
		}
		appointment.start = floatToTime(start);
		appointment.end = floatToTime(end);
		container.style.height = height;
		dispatch('deleteAppointment', nodes[index+1].id);
	}
}

const handleStopResize = (event) => {
	console.log('handle stop resize')
	dragEnd = true;
	window.removeEventListener('mousemove', handleMouseMove);
	updateAppointment(appointment)
		.catch(err=>{
			appointment = prevAppointment;
		})
}

const handleStartResize = (event) => {
	prevY = event.clientY;
	prevAppointment = appointment;
	window.addEventListener('mousemove', handleMouseMove);
	window.addEventListener('mouseup', handleStopResize);
}

const handleStartResizeTop = (event) => {
	top = true;
	dragEnd = false;
	handleStartResize(event);
}
const handleStartResizeBottom = (event) => {
	top = false;
	dragEnd = false;
	handleStartResize(event);
}
const updateAppointment = (newappointment) => {
	return axios.put('/api/appointments/update', newappointment);
}

let container = null;
let height = null;
onMount(()=>{
	// container.style.width = width;
		height = `${rowSpan*4}vh`;
		container.style.height = height;
});

onDestroy(()=>{
	unsubscribeSearch();
});


</script>


<div bind:this={container}
	class:disabled={disabled}
	class="cell-container grey">

	{#if appointment != null}
	<div class="btn-resize-top" on:mousedown|self|stopPropagation={handleStartResizeTop}>
			</div>
		<!-- content -->
		<div class="content"
		on:click|stopPropagation|preventDefault={handleClick}
			class:notregistered
			class:registered
			class:match
			class:nomatch>
			<div>
				{registered? appointment.user.last_name.charAt(0)+'. '+appointment.user.name: appointment.name}
			</div>
			<div>{appointment.phone}</div>

			<!-- show checkin state -->
			{#if checkin}
				<div class="state-row">
					<CheckInState {checkin} />
				</div>
			{/if}
			<!-- end show checkin state -->
		</div>
		<div class="btn-resize-btm" on:mousedown|self|stopPropagation={handleStartResizeBottom}>
			</div>

		<!-- appointment==null -->
		{:else}
		<div class="content empty"
			on:click|stopPropagation|preventDefault={handleClick}>
			{#if disabled}
				Эмчийн ээлжийн цаг биш
				{:else}
				Цаг захиалах <br />
				<h8>{time.str}</h8>
			{/if}
		</div> <!-- content end -->
	{/if}
		<AppointmentModal
			bind:show={showAppointmentModal}
			on:submit={handleSubmit}
			on:register={handleRegisterModal}
			on:delete={handleDelete}
			on:changeTime={handleChangeTime}
			start={appointment? appointment.start: null}
			end={appointment? appointment.end: null}
			{shift}
			{time}
			doctor={shift.doctor}
			bind:appointment={appointment} />

		<RegisterModal
			name={appointment?appointment.name:''}
			phone={appointment?appointment.phone:''}
			bind:show={showRegisterModal} 
			on:submit={handleRegister}/>

		<CheckInModal
			on:submit={handleSubmit}
			{shift}
			appointment={registeredAppointment}
			{time}
			bind:show={showCheckInModal}
			on:submit={handleSubmit} />

		<SameUsersModal 
			bind:show={showSameUsersModal}
  			on:submit={handleSubmitUser} 
  			on:cancel={handleCancelSameUsers}
  			bind:users={sameUsers} />
</div>

<style>

	.cell-container {
	  width: 100%;
	  height: 100%;
	  border: 1px solid #e0e0e0e0;
	  padding: 0;
	  color: #333333;
	  position: relative;
	}

	.state-row{
		position: absolute;
		top: 5%;
		right: 1%;

		display: flex;
		flex-direction: row;
		justify-content: flex-end;
		width:  100%;
	}

	.state-icon{
		width: 18px;
		height: 18px;
		margin: 2px;
		margin-bottom: 1vh;
	}

	.state-icon > img{
		max-width: 100%;
		height: auto;
	}

	.btn-resize-btm, .btn-resize-top{
		position: absolute;
		height: 12%;
		cursor: row-resize;
		width: 100%;
	}
	.btn-resize-top{
		top: 0;
		z-index: 100;
	}
	.btn-resize-btm{
		bottom: 0;
	}

	div:hover{
		transition: 0.4s;
	}

	div:hover .content{
		transition: 0.3s;
		/* background-color: #efefefef; */
		/* color: #363636; */
		filter: brightness(99%);
		cursor: pointer;
	}

	div:hover .empty{
		color: #444444;
		background-color: #efefefef;
	}

	.content{
		position: relative;
		font-size: 1.7vh;
		width: 100%; 
		height: 100%;
		display: flex;
		flex-flow: column wrap;
		justify-content: center;
		align-items: center;
		color: #332222;
	}

	.empty{
		color: #efefefef;
		background-color: #efefefef;
	}

	.notregistered{
		color: #333333;
		background-color: #eb972a;
	}

	.registered{
		color: #444444;
		background-color: white;
	}

	.match{

	}

	.nomatch{
		background-color: rgba(0, 0, 0, 0.5);
		color: #444444;
	}

	.disabled .content{
		color: #bdc3c7;
		background-color: #bdc3c7;
	}

	.disabled:hover .empty{
		color: #333333;
		cursor: auto;
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