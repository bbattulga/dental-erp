
{#each $treatmentHistories as th}

{#if th.tooth_id == 0}
<div class="col-md-12 text-left line" on:click={showHistoryDetail(th)}>
    <b>Бүх шүд - {th.treatment.name}</b>
    <div class="row">
        <div class="text-muted col-md-6">	
            
        </div>
        <div class="text-right text-muted col-md-6">
            {th.created_at}
        </div>
    </div>
</div>

{:else if (($selectedTooths.length == 0) || $toothStates[th.tooth_id].active)}
	<div class="col-md-12 text-left line" on:click={showHistoryDetail(th)}>
	    <b>{th.tooth_id == 0? 'Бүх шүд':`#${th.tooth_id}`} - {th.treatment.name}</b>
	    <div class="row">
	        <div class="text-muted col-md-6">	
	            {#if th.treatment.id == 1}
			    	<div>{th.tooth_type_id == 1? 'сүүн шүд':''}</div>
			    	<div>цоорол - {th.decay_level}</div>
			    {/if}
	        </div>
	        <div class="text-right text-muted col-md-6">
	            {th.created_at}
	        </div>
	    </div>
	</div>
{/if}
{/each}

<Dialog bind:this={dialog}
		style="z-index: 1050;">

	<Title>
		{treatmentHistory.tooth_id == 0? 'Бүх шүд':`Шүд #${treatmentHistory.tooth_id}`}
		 - {treatmentHistory.treatment.name}</Title>
	<Content>
		<h4>Шинж тэмдэг</h4>
		<div class="input-group">
			<!-- <div class="input-group-prepend">
				<span class="input-group-text">
					Шинж тэмдэг
				</span>
			</div> -->
			<Textfield textarea fullwidth bind:value={treatmentHistory.diagnosis} input$aria-controls="helper-text-textarea" 		input$aria-describedby="helper-text-textarea" />
		</div>
		<div class="mb-3"></div>
		<h4>Онош</h4>
		<div class="input-group">
			
			<!-- <div class="input-group-prepend">
				<span class="input-group-text">
					Онош
				</span>
			</div> -->
			<Textfield textarea fullwidth bind:value={treatmentHistory.diagnosis} input$aria-controls="helper-text-textarea" 		input$aria-describedby="helper-text-textarea" />
		</div>
	</Content>

	<Actions>
		<Button on:click={handleSaveNote} primary>
			<Label>Ok</Label>
		</Button>
	</Actions>

</Dialog>

<script>

	import Dialog, {Title, Content, Actions} from '@smui/dialog';
	import Textfield from '@smui/textfield';
	import Button, {Label} from '@smui/button';
	import {toothStates, treatmentHistories, selectedTooths} from './stores/store.js';
	import {deleteUserTreatment, getTreatmentImgSrc} from '../api/doctor-treatment-api.js';


	const handleDeleteHistory = (th) => {
		console.log('delete treatment history');
		deleteUserTreatment(th.id)
			.then(response=>{
				// update ui
				$treatmentHistories = $treatmentHistories.filter(e=>e.id != th.id);
				$toothStates[th.tooth_id].treatments.pop();
				$toothStates = $toothStates;
			})
			.catch(err=>{
				console.log(err);
			})
	}

	let dialog;
	let treatmentHistory = {
		tooth_id: 1,
		treatment: {name:''},
		symptom: '',
		diagnosis: ''
	}

	const showHistoryDetail = (th) => {
		treatmentHistory = th;
		dialog.open();
	}

	let symptom;
	let diagnosis;
	const handleSaveNote = () => {
		console.log('save');
		console.log(symptom.innerHTML);
		console.log(diagnosis.innerHTML);
	}

</script>