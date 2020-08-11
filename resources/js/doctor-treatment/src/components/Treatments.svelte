
{#each treatments as treatment}
<button 
class="btn btn-primary"
on:click={()=>handleClickTreatment(treatment)}
	on:blur={()=>console.log('onblur')}
	class:active={$selectedTreatment && (treatment.id==$selectedTreatment.id)}>
    <div class="row">
    	<div class="col-md-12">
            {treatment.name}
        </div>
    </div>
</button>
{/each}


<script>
import List, {Item, Text} from '@smui/list';
import {getTreatments} from '../api/doctor-treatment-api.js';
import {selectedTreatment} from './stores/store.js';
import Button, {Label} from '@smui/button';


let treatments = [];
getTreatments().then(response=>{
    treatments = response.data;
}).catch(err=>{
    console.log('error when fetching treatments');
    console.log(err);
    alert('page reload хийнэ үү');
});

const handleClickTreatment = (treatment) => {
    if ($selectedTreatment == treatment){
        $selectedTreatment = null;
        return;
    }
    $selectedTreatment = treatment;
}

</script>


<style>
	.active{
		background-color: #efefef;
	}
</style>