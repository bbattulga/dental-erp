<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	export let showModal = false;
	export let title = "";

	let dispatch = createEventDispatcher();

	let name = null;
	let phone = null;

	function close(){
		showModal = false;
		console.log('close modal');
	}
</script>


{#if showModal}
<div
	class="backdrop" on:click|self|stopPropagation={close}>
		<h2>{title}</h2>
		<slot></slot>	
}
</div>
{/if}



<style type="text/css">
	
	.backdrop{
		top: 0;
		left: 0;
		position: fixed;
		width: 100%;
		height: 100%;
		z-index:10000000;
		
		background-color: rgba(0, 0, 0, 0.5	);

		 -webkit-animation: fadein 0.3s; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: fadein 0.3s; /* Firefox < 16 */
        -ms-animation: fadein 0.3s; /* Internet Explorer */
         -o-animation: fadein 0.3s; /* Opera < 12.1 */
            animation: fadein 0.3s;
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