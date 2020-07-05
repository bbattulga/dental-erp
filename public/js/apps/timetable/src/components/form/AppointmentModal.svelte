<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	import RegisterForm from './RegisterForm.svelte';
	import {fly} from 'svelte/transition';
	import Modal from '../modal/Modal.svelte';


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
		dispatch('delete', appointment);
	}

	function toggleForm(){
		showAppointmentForm = !showAppointmentForm;
		showRegisterForm = !showRegisterForm;
	}
</script>

{#if show}

<Modal bind:showModal={show}>

{#if showAppointmentForm}
<div
	class="form" target="#"
	transition:fly="{{y:-100, duration: 550}}">


	<header>
		<h1>{(appointment == null)? 'Цаг захиалах':'Захиалгын мэдээлэл'}</h1>
	</header>

	<div class="main">

		<div class="row-input">
			<label>Үйлчлүүлэгчийн нэр:</label>
			<input bind:value={name}>
		</div>

		<div class="row-input">
			<label>Утас:</label>	
			<input bind:value={phone}>
		</div>

		<div class="title-sub">
			<label>Эмчийн нэр  -   <strong>{doctor.name}</strong></label>
			<div>Эмчилгээний цаг  -  {(start)+':00'} - {(end)%24+':00'}</div>
		</div>
		<!-- show input fields if user is null -->
		<!-- i.e no user in this cell -->
		{#if appointment == null}
			<div class="row-input">
				<label>Хугацаа(цагаар):</label> <br />
				<input type="number" bind:value={hours} style="width: 100px;">
			</div>
		{/if}
	</div>

	<footer>

		<button 
			on:click|preventDefault|stopPropagation={handleSubmit}
			class="btn btn-add">ok</button>
	<button 
		class="btn-cancel"
		on:click|preventDefault|stopPropagation={close}>x</button>
		
		{#if appointment != null}
			<button 
				class="btn-del"
				on:click={handleDelete}>cancel</button>
		{/if}
	<!--	<button on:click={toggleForm}>register</button> -->
		<button><a href="/reception/user">register</a></button>
	</footer>
</div>
{/if} <!-- show appointmentform -->
{#if showRegisterForm}
	<RegisterForm />
{/if}
</Modal>
{/if}



<style type="text/css">
	
	*{
		box-sizing: border-box;
		font-weight: 10;
		font-family: Arial Helvetica sans-serif;
	}

	.form{

		display: flex;
		flex-direction: column;
		top: 50%;
		left: 50%;
		position: relative;
		transform: translate(-50%, -50%);
		width: 200px;
		border-radius: 10px;
		padding: 10px;
		background-color: white;
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
		margin: 30px;
	}
	@media (max-height: 600px){
		.row-input{
			display: block;
		}
		.form{
			width: 450px;
			height: 70%;
			overflow: auto;
		}
	}
	.btn-add{
		margin: 10px auto;
		padding: 10px 20px;
		background-color: orange;
		color: white;
	}

	.btn-del{
		position: absolute;
		top: 0;
		left: 0;
		background-color: orange;
		color: white;
	}

	.btn-add:hover{
		background-color: 1px 2px 4px black;
	}

	.btn-cancel{
		position: absolute;
		top: 0;
		right: 0;
	}

	input{
		width: 100%;
	}
</style>