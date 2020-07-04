<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';

	export let showModal = false;
	export let title = "";

	let dispatch = createEventDispatcher();

	let name = null;
	let phone = null;

	function close(){
		showModal = false;
	}
</script>


{#if showModal}
<div class="backdrop" on:click|self={close}>
	<div class="modal">
		<h2>{title}</h2>
		<slot></slot>
	</div>
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
	}

	.modal{
		text-align: center;	
		margin: 10px auto;
		width: 500px;

		background-color: white;
		border-radius: 10px;
		padding: 20px;
	}
</style>