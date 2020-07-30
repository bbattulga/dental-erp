<script>

	import {onMount} from 'svelte';

	export let checkin;
	export let iwidth = 18;
	export let iheight = 18;

	let iconContainer;
	onMount(()=>{
		iconContainer.style.fontSize = `${iwidth}px`;
	});

</script>

{#if checkin}
	{#if checkin.state == 0}
		<div bind:this={iconContainer} class="icon iconsmind-Over-Time2" style="color: blue;"></div>
		{:else if checkin.state == 1}
		<div bind:this={iconContainer} class="icon iconsmind-Nurse"></div>
		{:else if checkin.state == 2}
		<div bind:this={iconContainer}  class="icon iconsmind-Money-2" style="color: green;">
		</div>
		{:else}
		<div bind:this={iconContainer}  class="icon iconsmind-Yes">
		</div>
	{/if}
{/if}


<style>

.state-icon{
	width: 18px;
	height: 18px;
}

.icon{
	color: #2a7eeb;
}
</style>