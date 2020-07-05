<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';

	export let show = true;
	export let detail = null;

	let dispatch = createEventDispatcher();

	let empty = detail.user == null;
	let name = empty? '': detail.user.name;
	let phone = empty? '': detail.user.phone;
	let hours = empty? 1: detail.hours;
	let start = parseInt(detail.time.slice(0, detail.time.indexOf(':')));
	let end = 0;
	$: end = start+hours;

	function close(){
		show = false;
	}

	function handleSubmit(){

		console.log('submit new user');

		let data = {
			shift_id: detail.shift_id,
			user_id: 0,
			name: name,
			phone: phone,
			hours,
			start,
			end
		}
		// just visited or edited existing user cell
		if (detail.user != null){
			close();
		}

		// create new user
		// if cell did not have user
		
		close();
	}
</script>

{#if show}
<div class="form" target="#"
	on:click|stopPropagation>

		<header>
			<h1>{(detail.user == null)? 'Цаг захиалах':'Захиалгын мэдээлэл'}</h1>
			<div>{detail.doctor.name}</div>
			<div>{(start)+':00'} - {(end)%24+':00'}</div>
		</header>
		<!-- show input fields if user is null -->
		<!-- i.e no user in this cell -->
		{#if detail.user == null}
			<label>Хугацаа(цагаар):</label>
			<input type="number" bind:value={hours} style="max-width: 10%;">
		{/if}

			<div class="row-input">
				<label>Үйлчлүүлэгчийн нэр:</label>
				<input bind:value={name}>
			</div>

			<div class="row-input">
				<label>Утас:</label>	
				<input bind:value={phone}>
			</div>

		<button 
			on:click|preventDefault|stopPropagation={handleSubmit}
			class="btn btn-add">ok</button>

	<button 
		class="btn-cancel"
		on:click|stopPropagation={close}>cancel</button>
</div>
{/if}



<style type="text/css">
	
	*{
		font-size: 16px;
		font-weight: 10;
		font-family: Arial Helvetica sans-serif;
	}

	.form{
		top: 50%;
		left: 50%;
		position: fixed;
		transform: translate(-50%, -50%);
		overflow: auto;
		height: 60%;
		width: 20%;
		padding: 1%;
		border-radius: 10px;
		background-color: white;
	}

	.row-input{
		text-align: left;
		max-width: 100%;
		margin: 30px;
	}

	.btn-add{
		margin: 10px;
	}

	.btn-add:hover{
		background-color: 1px 2px 4px black;
	}

	.btn-cancel{
		position: absolute;
		top: 0;
		right: 0;
		float: right;
	}

	input{
		width: 100%;
	}
</style>