
<script>

	import {createEventDispatcher} from 'svelte';

	export let user = null;
	export let doctor = null;
	export let colspan = 1;
	export let time = null;

	// conditional classes
	let empty =  user == null;
	let newUser = !empty && (user.registered == "0");
	let registered = !empty && (user.registered == "1");

	// dispatch events
	let dispatch = createEventDispatcher();

	const handleClick = ()=>{

		let detail = {
			user,
			doctor,
			time
		};

		dispatch('click', detail);
	}
</script>


<td {colspan} 
	on:click={handleClick}
	class:registered={registered}
	class:empty={empty}
	class:newuser={newUser}>

	{#if user == null}
		tsag zahialah
		{:else}
		{user.name}
	{/if}
</td>


<style type="text/css">
	
	td{
		background-color: white;
		width: 80px;
		height: 80px;
		color: grey;
		border-radius: 10px;
		margin: 5px;
		transition: 0.3s;
		padding: 5px;
	}

	.empty{
		
	}

	.empty:hover{
		color: black;
	}

	.newuser{
		color: black;
		background-color: yellow;
	}

	.registered{
		color: black;
		background-color: green;
	}

	.newuser:hover{
		background-color: yellow;
		color: black;
	}

	.registered:hover{
		background-color: green;
	}
</style>