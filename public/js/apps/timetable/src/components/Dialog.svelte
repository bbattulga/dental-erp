<script type="text/javascript">
	
	export let active;
	export let user;
	console.log('useri n Dialog.svelte '+user);
	function close(){
		console.log('close');
		active = !active;
	}
</script>


<div class="dialog {active == true? 'show':'hide'}">
	
	<button on:click={close}>close</button>
	<p style="color: white;">user.name</p>

</div>



<style type="text/css">

	.dialog{
		background-color: #333333;
		border-radius: 10px;

    -webkit-animation: fadein 0.7s; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: fadein 0.7s; /* Firefox < 16 */
        -ms-animation: fadein 0.7s; /* Internet Explorer */
         -o-animation: fadein 0.7s; /* Opera < 12.1 */
            animation: fadein 0.7s;
	}

	.show{
		position: fixed;
		display: block;
		width: 500px;
		height: 500px;
		top: 10%;
		left: 50%;
		transform: translateX(-50%);
	}

	.hide{
		display: none;
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