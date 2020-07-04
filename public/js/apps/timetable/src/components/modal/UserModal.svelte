<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';

	export let showModal = false;
	export let detail = null;
	export let subtitle;

	console.log(detail);
	let dispatch = createEventDispatcher();

	let user = detail.user;
	let name = user == null? "":user.name;
	let phone = user == null? "":user.phone;
	let time = detail.time == null? "":detail.time;

	function close(){
		showModal = false;
	}

	function handleSubmit(){

		let user = {
			name,
			phone
		};
		dispatch('submit', user);
		close();
	}
</script>

<form class="form">

	<h2>{user == null? "Цаг захиалах": "Цаг захиалсан"}</h2>
	<h4>{user == null? "": user.start+"-"+user.end}</h4>

	<div class="row-input">
		<label>Үйлчлүүлэгчийн нэр:</label>
		<input bind:value={name}>
	</div>

	<div class="row-input">
		<label >Утас:</label>
		<input bind:value={phone}>
	</div>
	<button class="btn btn-add" on:click|preventDefault={handleSubmit}>ok</button>
</form>



<style type="text/css">
	
	.backdrop{
		top: 0;
		left: 0;
		position: fixed;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.7);
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
		width: 100%;
	}

	.btn-add{
		margin: 10px;
	}

	input{
		width: 100%;
	}
</style>