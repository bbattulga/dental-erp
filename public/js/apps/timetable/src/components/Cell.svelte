
<script>

	import {createEventDispatcher} from 'svelte';

	export let user;

	const dispatch = createEventDispatcher();
	let noUser =(user == null);
	if (noUser){
		user = {name: "Цаг захиалах"}
	}

	function notifyClick(event){
		dispatch('click', {
			user: user
		});
	}

</script>


<td 
	on:click={notifyClick}
	class:empty={noUser}
	class:registered={!noUser && (user.registered=="1")}
	class:newuser={!noUser && (!user.registered=="0")}>
	<div>
		<p>{user.name}</p>
		<p>{user.phone == null? "":user.phone}</p>
	</div>
</td>


<style type="text/css">
	
	td{
		width: 80px;
		color: grey;
		background-color: #e2e2e2e2;
		border-radius: 10px;
		margin: 5px;
		transition: 0.3s;
	}

	.empty{
		
	}

	.empty:hover{
		color: black;
		background-color: #e1e1e1e1;
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