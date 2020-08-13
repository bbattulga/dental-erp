<script>
	import {createEventDispatcher} from 'svelte';
	import {selectedTooth, selectedTreatment, toothStates} from './stores/store.js';
	import {getTreatmentImgSrc} from '../api/doctor-treatment-api.js';
	import {selectedTooths} from './stores/store.js';

	export let toothCode = 11;
	const dispatch = createEventDispatcher();

	let active = null;
	let imgSrc = null;
	let lastTreatmentId = null;
	let treatments = null;

	$: {
		treatments = $toothStates[toothCode].treatments;
		lastTreatmentId = treatments[treatments.length-1]!=null? treatments[treatments.length-1]:null;
		imgSrc = getTreatmentImgSrc(toothCode, lastTreatmentId);
	}
	$: active = $toothStates[toothCode].active;
	
	const handleClick = (event) => {

		let detail = {
			toothCode
		}
		dispatch('click', detail);
	}

</script>


<img on:click={handleClick} src={imgSrc}
	class:active
	class:tooth={!active}>


<style>
	.active{

	}

	.disabled{
		opacity: 0.5;
	}
</style>