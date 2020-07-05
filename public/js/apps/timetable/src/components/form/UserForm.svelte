<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';

	export let show = true;
	export let detail = null;
	export let subtitle;

	let dispatch = createEventDispatcher();

	let user = detail.user;
	let name = user == null? "":user.name;
	let phone = user == null? "":user.phone;

	let start = parseInt(detail.time.slice(0, detail.time.indexOf(':')));
	let hours = 1;

	function close(){
		show = false;
	}

	let till = detail.time;

	function handleSubmit(){

		// just visited or edited existing user cell
		if (detail.user != null){
			close();
		}

		// create new user
		// if cell did not have user
		let user = {
				name,
				phone,
				start,
				hours,
				end: start+hours
			}

		let _detail = {
			user
		}
		
		dispatch('submit', _detail);
		
		close();
	}
</script>

{#if show}
<div class="form" target="#">

	<h3>{user == null? "Цаг захиалах": "Цаг захиалсан"}</h3>

	<div class="row-input">
		<h4>Эмчийн нэр: {detail.doctor.name}</h4>
		<h4>Хугацаа: {user == null? (detail.time+'-'+(start+hours)+':00'): user.start+"-"+user.end}</h4>

		{#if user == null}
		<input style="width: 60px;" type="number" bind:value={hours}>
		{/if}

	</div>

	<div class="row-input">
		<label>Үйлчлүүлэгчийн нэр:</label>
		<input bind:value={name}>
	</div>

	<div class="row-input">
		<label >Утас:</label>
		<input type="number" bind:value={phone}>
	</div>
	<button class="btn btn-add" on:click={handleSubmit}>ok</button>
</div>
{/if}



<style type="text/css">
	
	.backdrop{
		top: 0;
		left: 0;
		position: fixed;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.7);
		transition: 0.5s;
	}

	.modal{
		text-align: center;	
		margin: 10px auto;
		width: 500px;

		background-color: white;
		border-radius: 10px;
		padding: 20px;
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

	input{
		width: 100%;
	}
</style>