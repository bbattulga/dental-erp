
<script>

	import {createEventDispatcher} from 'svelte';

	export let user = null;
	export let doctor = null;
	export let shift_id = null;
	export let colspan = 1;
	export let start = null
	export let time = null;
	export let end = null;
	export let hours = null;

	console.log('cell got user ', user);
	console.log('cell shift_id ', shift_id);

	// conditional classes
	let empty =  user == null;
	let newUser = !empty && (user.user_id == "0");
	let registered = !empty && (user.user_id != "0");

	// dispatch events
	let dispatch = createEventDispatcher();

	const handleClick = ()=>{

		let detail = {
			user,
			doctor,
			time,
			start,
			hours,
			end
		};

		dispatch('click', detail);
	}
</script>


<td {colspan} 
on:click={handleClick}>

<div class="user"
	class:registered={registered}
	class:empty={empty}
	class:newuser={newUser}>
	{#if user == null}
	<h4>Цаг захиалах</h4>
	{:else}
	<p>{user.name}</p>
	<p>{user.phone}</p>
	{/if}
</div>
</td>


<style type="text/css">
	
	td{
		width: 80px;
		color: grey;
		transition: 0.3s;
		border: 3px solid #cccccc;

	}

	.user{
		background-color: #333333;
		margin: 5px;
		padding: 2px;
		border-radius: 10px;
	}

	.empty{
		visibility: hidden;
	}

	td:hover .empty{
		visibility: visible;
		background-color: grey;
		color: white;
		display: block;

		-webkit-animation: fadein 0.7s; /* Safari, Chrome and Opera > 12.1 */
       	-moz-animation: fadein 0.7s; /* Firefox < 16 */
        -ms-animation: fadein 0.7s; /* Internet Explorer */
         -o-animation: fadein 0.7s; /* Opera < 12.1 */
            animation: fadein 0.7s;
	}

	.newuser{
		color: white;
		background-color: #f05e23;
	}

	.registered{
		color: white;
		background-color: green;
	}

	.newuser:hover{
		color: white;
		background-color: #f05e23;
	}

	.registered:hover{
		background-color: green;
	}

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