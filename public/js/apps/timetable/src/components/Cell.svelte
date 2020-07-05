
<script>

	import {createEventDispatcher} from 'svelte';

	import Modal from './modal/Modal.svelte';
	import UserForm from './form/UserForm.svelte';
	import {onMount} from 'svelte';
	onMount(()=>{console.log('cell onMount')});

	// dispatch events
	let dispatch = createEventDispatcher();

	export let data = null;

	// conditional classes
	let empty =  (data.user === null);
	let newUser = !empty && (data.user.user_id == "0");
	let registered = !empty && (data.user.user_id != "0");

	let showModal = false;

	function handleClick(){
		showModal = true;
	}

	const handleSubmit = ()=>{
		console.log('cell handle submit');
	}

</script>


<td colspan={data.hours} 
on:click={handleClick}>
	<div class="u"
	class:registered={registered}
	class:empty={empty}
	class:newuser={newUser}>
		{#if data.user == null}
			<h4>Цаг захиалах</h4>
		{:else}
			<p>{data.user.name}</p>
			<p>{data.user.phone}</p>
		{/if}
	</div>
	<Modal
		bind:showModal={showModal}>
		<UserForm 
			bind:show={showModal}
			on:submit={handleSubmit}
			detail={data} />
	</Modal>
</td>


<style type="text/css">
	
	td{
		width: 80px;
		transition: 0.3s;
		border: 3px solid #cccccc;
	}

	.u{
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
		cursor:pointer;

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