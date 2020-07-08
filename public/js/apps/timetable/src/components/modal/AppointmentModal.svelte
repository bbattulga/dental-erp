<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	import {fly} from 'svelte/transition';
	import Modal from './Modal.svelte';


	export let show = true;
	export let shift;
	export let doctor;
	export let appointment;
	export let time;

	let showAppointmentForm = true;
	let showRegisterForm = false;
	// dispatch events
	let dispatch = createEventDispatcher();

	// assign default values
	let empty = appointment == null;
	let name = empty? '': appointment.name;
	let phone = empty? '': appointment.phone;
	let hours = empty? 1: appointment.end-appointment.start;
	let start = parseInt(time.slice(0, time.indexOf(':')));
	let end = 0;
	let cancelCode = '';

	// re-eval end on user change hours
	$: end = start+hours;

	function close(){
		console.log('close');
		show = false;
		console.log(show);
	}

	function handleSubmit(){

		// just visited or edited existing user cell
		if (appointment!= null){
			close();
			return;
		}

		console.log('submit new user');

		let _detail = {
			appointment:{
				shift_id: shift.id,
				user_id: 0,
				name: name,
				phone: phone,
				hours,
				start,
				end
			}
		}

		dispatch('submit', _detail);
		// create new user
		// if cell did not have user
		
		close();
	}

	function handleDelete(){
		//console.log('form trying to del ', appointment);
		appointment.code = cancelCode;
		dispatch('delete', appointment);
	}

	function toggleForm(){
		showAppointmentForm = !showAppointmentForm;
		showRegisterForm = !showRegisterForm;
	}

	function handleRegister(){
		close();
		let currentData = {
			name,
			phone
		}
		dispatch('openRegister', currentData);
	}

</script>


<Modal bind:showModal={show}>
<div
	class="form" target="#"
	transition:fly="{{y:-100, duration: 550}}">


	<header>
		<h1>{(appointment == null)? 'Цаг захиалах':'Захиалгын мэдээлэл'}</h1>
		<hr>
	</header>

	<div class="main">

		<div class="row-input">
			<label>Үйлчлүүлэгчийн нэр:</label>
			<input bind:value={name} readonly="{appointment != null}">
		</div>

		<div class="row-input">
			<label>Утас:</label>	
			<input bind:value={phone} readonly="{appointment != null}">
		</div>

		<div class="title-sub">
			<label>Эмчийн нэр  -   <strong>{doctor.name}</strong></label>
			<div>Эмчилгээний цаг  -  {(start)+':00'} - {(end)%24+':00'}</div>
		</div>
		<!-- show input fields if user is null -->
		<!-- i.e no user in this cell -->
		{#if (appointment == null)}
			<div class="row-input">
				<label>Хугацаа(цагаар):</label> <br />
				<input style="display: inline-block; width: 100px;" type="number" bind:value={hours}>

				<div style="text-align: right;">
				<button 
			on:click|preventDefault|stopPropagation={handleSubmit}
			class="btn btn-add">Цаг захиалах</button>
		</div>
			</div>
		{/if}

		<hr>
	</div>


		<div 
		class="btn-cancel"
		on:click|preventDefault|stopPropagation={close}>
			<img src="/js/apps/timetable/src/components/assets/close.png">
		</div>
	<footer>
		
		{#if (appointment != null)}

		{#if (appointment.registered != '1')}
		<button 
			on:click|preventDefault|stopPropagation={handleRegister}
			class="btn btn-add">Бүртгэх</button>
		{/if}
			<div class="container-cancel">

				<input hint="нууц код" class="input-cancel" type="text" bind:value={cancelCode}>
			<button 
				on:click={handleDelete}>Цуцлах</button>
			</div>
		{/if}
	</footer>
</div>
</Modal>



<style type="text/css">

	input{
		background: white;
		width: 100%;
		border: 1px solid grey;

		border-radius: 3px;
	}

	footer{
		position: relative;
		display: flex;
		flex-direction: row-reverse;
		align-items: center;
		width: 100%;
	}

	
	*{
		box-sizing: border-box;
		font-weight: 10;
		font-family: Arial Helvetica sans-serif;
	}

	.form{
		position: relative;
		top: 10%;
		left: 50%;
		width: 60%;
		max-height: 80%;
		transform: translate(-50%, -10%);
		border-radius: 10px;
		padding: 30px;
		background-color: white;
		overflow: auto;
	}

	.title-sub{
		text-align: left;
		margin: 30px;
	}

	.row-input{
		display: grid;
		grid-template-columns: 3fr 7fr;
		text-align: left;
		max-width: 100%;
	}

	/*

	@media (max-width:  900px){

		label{
		margin-right: 5px;
	}


		.row-input{
			display: block;
		}
		.form{
			min-width: 80%;
			max-height: 80%;
		}
	}
	@media (max-width: 700px){
		.row-input{
			display: block;
		}
		.form{
			min-width: 80%;
			max-height: 100%;
		}
	}
	*/

	.btn-add{
		display: inline-block;
		padding: 10px 20px;
		width: 40%;
		float: right;
		background-color: #0c374d;
		color: white;
	}

	.btn-add:hover{
		background-color: #093145;
	}

	.btn-cancel{
		position: absolute;
		top: 0;
		right: 0;
		width: 32px;
		height: 32px;
		margin: 10px;
	}

	.btn-cancel img{
		max-width: 100%;
		height: auto;
		cursor: pointer;
	}

	.container-cancel{
		position: absolute;
		left: 0;
		display: grid;
		grid-template-columns: 7fr 3fr;
		grid-gap: 5px;
		background: white;
		width: 50%;
	}

	.input-cancel{

	}
</style>