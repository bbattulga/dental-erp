<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';

	export let show = true;
	export let shift;
	export let doctor;
	export let appointment;
	export let time;

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
		show = false;
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

</script>

{#if show}
<div class="form" target="#"
	on:click|stopPropagation>


	<header>
		<h1>{(appointment == null)? 'Цаг захиалах':'Захиалгын мэдээлэл'}</h1>
	</header>

	<div class="main">

		<div class="title-sub">
			<div>{doctor.name}</div>
			<div>{(start)+':00'} - {(end)%24+':00'}</div>
		</div>
		<!-- show input fields if user is null -->
		<!-- i.e no user in this cell -->
		{#if appointment == null}
		<div class="row-input">
			<label>Хугацаа(цагаар):</label> <br />
			<input type="number" bind:value={hours} style="max-width: 10%;">
		</div>
		{/if}

		<div class="row-input">
			<label>Үйлчлүүлэгчийн нэр:</label>
			<input bind:value={name}>
		</div>

		<div class="row-input">
			<label>Утас:</label>	
			<input bind:value={phone}>
		</div>
	</div>

	<footer>

		<button 
			on:click|preventDefault|stopPropagation={handleSubmit}
			class="btn btn-add">ok</button>
	<button 
		class="btn-cancel"
		on:click|stopPropagation={close}>x</button>
		
		{#if appointment != null}
			<button 
				class="btn-del"
				on:click={handleDelete}>cancel</button>
		{/if}

	</footer>
</div>
{/if}



<style type="text/css">
	
	*{
		font-weight: 10;
		font-family: Arial Helvetica sans-serif;
	}

	.form{
		display: grid;
		grid-template-rows: 1fr 8fr 1fr;
		top: 20px;
		left: 50%;
		position: fixed;
		transform: translateX(-50%);
		overflow: auto;
		width: 500px;
		height: 500px;
		padding: 1%;
		border-radius: 10px;
		background-color: white;
	}

	.title-sub{
		font-size: 1.5em;
	}

	.row-input{
		font-size: 1.2em;
		text-align: left;
		max-width: 100%;
		margin: 30px;
	}

	.btn-add{
		margin: 10px;
	}

	.btn-del{
		position: absolute;
		top: 0;
		left: 0;
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
		font-size: 1em;
		width: 100%;
	}
</style>