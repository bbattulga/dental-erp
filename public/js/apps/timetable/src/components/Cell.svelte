
<script>

	import {createEventDispatcher} from 'svelte';

	export let user = null;
	export let doctor = null;
	export let time = null;

	const dispatch = createEventDispatcher();

	let title = user == null? 'Цаг захиалах':user.name;
	let subtitle = user == null? '': user.phone;

	function notifyClick(event){
		dispatch('click', {
			user,
			doctor,
			time
		});
	}

	let d = 1;
	if (user != null){
		let start = user.start;
		let end = user.end;

		let colon = start.indexOf(':');

		let sh = start.slice(0, colon);
		let sm = start.slice(colon+1, start.length);

		let eh = end.slice(0, colon);
		let em = end.slice(colon+1, end.length);
		d =  parseInt(eh) - parseInt(sh);
	}

</script>


<td 
	colspan={d}
	on:click={notifyClick}
	class:empty={user==null}
	class:registered={(user!=null) && (user.registered=="1")}
	class:newuser={(user!=null) && (!user.registered=="0")}>
	<div>
		<p>{title}</p>
		<p>{subtitle}</p>
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