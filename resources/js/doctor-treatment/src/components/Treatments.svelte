
<div class="d-flex align-items-center">
    <div class="search mt-2" data-search-path="Layouts.Search.html?q="
        style="margin: 0 auto;">
        <input placeholder="хайх..." bind:value={searchVal}>
        <span class="search-icon">
            <i class="simple-icon-magnifier"></i>
        </span>
    </div>
</div>

<div id="treatmentsContainer" class="card-body" on:click={onOpen}>
    {#each $treatments as treatment}

    {#if searchVal.length == 0 || isMatch(searchVal, treatment.name)}
        <button 
        class="btn btn-primary btn-block"
        on:click={()=>handleClickTreatment(treatment)}
        	class:active={$selectedTreatment && (treatment.id==$selectedTreatment.id)}>
            <div class="row">
            	<div class="col-md-12">
                    {treatment.name}
                </div>
            </div>
        </button>
    {/if}
    {/each}
</div>

<Dialog
  bind:this={allToothDialog}
  aria-labelledby="dialog-title"
  aria-describedby="dialog-content"
  style="z-index: 1050;"
>
  <Title id="dialog-title">{clickedTreatment? clickedTreatment.name:''}</Title>
  <Content id="dialog-content">
    Бүх шүдэнд хийгдэх эмчилгээ байна
  </Content>
  <Actions>
    <Button>
      <Label>болих</Label>
    </Button>
    <Button on:click={handleAddTreatment}>
      <Label>Үргэлжлүүлэх</Label>
    </Button>
  </Actions>
</Dialog>


<script>
import List, {Item, Text} from '@smui/list';
import {selectedTreatment, treatments} from './stores/store.js';
import Dialog, {Title, Content, Actions} from '@smui/dialog';
import Button, {Label} from '@smui/button';
import {checkin, treatmentHistories} from './stores/store.js';

let allToothDialog;
let clickedTreatment;

const handleClickTreatment = (treatment) => {
    clickedTreatment = treatment;
    console.log('previous treatment', $selectedTreatment);
    if ($selectedTreatment == treatment){
        $selectedTreatment = 0;
        return;
    }

    // make sure fora all tooths
    if (treatment.selection_type == 0){
        console.log('open all treatment dialog');
        allToothDialog.open();
        return;
    }
    console.log('selected treatment', treatment);
    $selectedTreatment = treatment;
}   

const handleAddTreatment = () => {
    let userTreatment = {
            id: null,
            checkin_id: $checkin.id,
            user_id: $checkin.user_id,
            treatment_id: clickedTreatment.id,
            treatment: clickedTreatment,
            treatment_selection_id: 0,
            treatment_selection: null,
            tooth_id: 0,
            price: null,
            symptom: '',
            diagnosis: '',

            value: 0,
            decay_level: 0,
            tooth_type_id: 0,
            created_at: new Date().toLocaleDateString('en-CA')
        }

    $treatmentHistories = [...$treatmentHistories, userTreatment];
}

let searchVal = '';

const isMatch = (keyword, value) => {
    let regex = new RegExp(keyword, 'i');
    return regex.exec(value);
}
const onOpen = () => {

}
</script>


<style>
	.active{
		background-color: #efefef;
	}
</style>