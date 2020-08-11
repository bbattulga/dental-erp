<script>
	import {createEventDispatcher} from 'svelte';
	import {selectedTooth, selectedTreatment, toothStates} from './stores/store.js';
	import {getTreatmentImgSrc} from '../api/doctor-treatment-api.js';
	import {selectedTooths} from './stores/store.js';

	export let toothCode = 11;
	let active = true;
	const dispatch = createEventDispatcher();

	let treatmentId = null;
	let baseSrc = getTreatmentImgSrc(toothCode, null);
	let imgSrc = baseSrc;
	$: imgSrc = $toothStates[toothCode].imgSrc;
	$: active = $toothStates[toothCode].active;
	$: treatmentId = $toothStates[toothCode].treatmentId;

	const handleClick = (event) => {
		let detail = {
			treatmentId,
			toothCode
		}

		dispatch('click', detail);
	}

</script>


<img on:click={handleClick} src={imgSrc}
	class:active
	class:disabled={!active}>


<style>
	.active{

	}

	.disabled{
		opacity: 0.5;
	}
</style>