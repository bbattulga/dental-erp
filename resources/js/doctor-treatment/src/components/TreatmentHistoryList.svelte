
{#each $treatmentHistories as th}
<div class="col-md-12 text-left line">
    <button on:click={()=>handleDeleteHistory(th)}>del</button>
    <b>Шүд - #{th.tooth_id} - {th.treatment.name}</b>
    <div class="row">
        <div class="text-muted col-md-6">
            selection
        </div>
        <div class="text-right text-muted col-md-6">
            
        </div>
    </div>
</div>
{/each}


<script>

	import {toothStates, treatmentHistories} from './stores/store.js';
	import {deleteUserTreatment, getTreatmentImgSrc} from '../api/doctor-treatment-api.js';


	const handleDeleteHistory = (th) => {
		console.log('delete treatment history');
		deleteUserTreatment(th.id)
			.then(response=>{
				// update ui
				$treatmentHistories = $treatmentHistories.filter(e=>e.id != th.id);
				$toothStates[th.tooth_id].imgSrc = getTreatmentImgSrc(th.tooth_id, null);
				$toothStates = $toothStates;
			})
			.catch(err=>{
				console.log(err);
			})
	}

</script>