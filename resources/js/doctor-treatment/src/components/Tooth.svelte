<script>
	import {createEventDispatcher} from 'svelte';
	import {selectedTooth, selectedTreatment, toothStates} from './stores/store.js';
	import {getTreatmentImgSrc} from '../api/doctor-treatment-api.js';
	import {selectedTooths,
			dateInterval} 
		from './stores/store.js';

	import moment from 'moment';

	export let toothCode = 11;
	const dispatch = createEventDispatcher();

	let active = null;
	let imgSrc = null;
	let lastTreatment = null;
	let treatments = null;

	$: {
		let state = $toothStates[toothCode];
		treatments = state.treatments;

		lastTreatment = null;
		let v = 0;
		for (let i=0; i<treatments.length; i++){
			if (treatments[i].created_at <= $dateInterval[1]){
				lastTreatment = treatments[i].treatment;
				break;
			}
		}
		// $toothStates[toothCode].value = lastTreatment? lastTreatment.value: 0;
		let lastTreatmentId = lastTreatment == null? null:lastTreatment.id;
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