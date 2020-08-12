<script>

	import ToothChart from './components/ToothChart.svelte';
	import SideMenu from './components/SideMenu.svelte';
	import {selectedTreatment, selectedTooth} from './components/stores/store.js';
	import {treatmentHistories} from './components/stores/store.js';
	import {checkin, patient} from './components/stores/store.js';
	import TreatmentHistories from './components/TreatmentHistories.svelte';


	$checkin = document.getElementById('checkin');
	$patient = checkin.user;

	$:{
		if ($selectedTreatment)
			console.log('selected treatment', $selectedTreatment);
	}
	$:console.log('selected tooth:', $selectedTooth);

	let showTreatmentHistories = false;

	const handleBook = (event) => {
		showTreatmentHistories = true;
		console.log('show histories');
		console.log(showTreatmentHistories);
	}

</script>

<div class="row">
    <ToothChart>
		<div slot="topleft" class="glyph" data-toggle="modal" data-target="#allNotesModal">
            <div on:click={()=>handleBook} class="glyph-icon simple-icon-notebook" ></div>
        </div>
    </ToothChart>

    <SideMenu />

    <TreatmentHistories 
    	treatmentHistories={$treatmentHistories}
    	bind:show={showTreatmentHistories}/>
</div>

<style>

</style>