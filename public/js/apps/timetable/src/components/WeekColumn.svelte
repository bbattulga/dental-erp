<script type="text/javascript">
	
	import {onMount} from 'svelte';
	import {createEventDispatcher} from 'svelte';


	export let width = '8vw';
	export let height = '10%';
	export let threshold = 0;

	const dispatch = createEventDispatcher();

	// if true, we resized top else we resized bottom.
	let resizeTop = false;

	let prevY = null;
	let deltaY = 0;
	let container = null;
	onMount(()=>{
		container.style.width = width;
		container.style.height = height;
	});

	const handleMouseMove = (event) => {
		deltaY = prevY - event.clientY;
		if (deltaY > threshold){
			deltaY = 0;
			prevY = y;
			if (threshold == 0)
				dispatch('stepTop', {deltaY});
		}else if (deltaY < -threshold){
			deltaY = 0;
			prevY = y;
			if (threshold == 0)
				dispatch('stepBottom', {deltaY});
		}
	}

	const handleStopTopResize = (event) => {
		window.removeEventListener('mousemove', handleMouseMove);
	}

	const handleTopStartResize = (event) => {
		resizeTop = true;
		prevY = event.clientY;
		window.addEventListener('mousemove', handleMouseMove);
		window.addEventListener('mouseup', handleStopTopResize);
	}

	const handleStopBottomResize = (event) => {
		window.removeEventListener('mousemove', handleMouseMove);
	}

	const handleBottomStartResize = (event) => {
		resizeTop = false;
		prevY = event.clientY;
		window.addEventListener('mousemove', handleMouseMove);
		window.addEventListener('mouseup', handleStopBottomResize);
	}
</script>

<div bind:this={container}
	class="resizable-container">
	<div class="btn-resize-top" on:mousedown|stopPropagation={handleTopStartResize}></div>
			<slot></slot>
	<div class="btn-resize-btm" on:mousedown|stopPropagation={handleBottomStartResize}></div>
</div>


<style>

	.resizable-container{

	}

	
	.btn-resize-btm, .btn-resize-top{
		position: absolute;
		width: 100%;
		height: 2vh;
		cursor: row-resize;
	}
	.btn-resize-top{
		top: 0;
	}
	.btn-resize-btm{
		bottom: 0;
	}

</style>