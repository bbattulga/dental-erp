
{#each $treatmentHistories as th}


{#if th.tooth_id == 0}
<div class="col-md-12 text-left thcontainer" on:click={showHistoryDetail(th)}
	style="cursor: pointer;"
	class:now={th.checkin_id>0}
	class:existing={th.checkin_id == 0}>

	{#if th.created_at <= $dateInterval[1]}
	<div class="glyph" style="display: flex; justify-content: flex-end;">
        <div class="glyph-icon iconsmind-Remove" on:click|stopPropagation={()=>handleDelete(th)}></div>
    </div>
    <b>Бүх шүд - {th.treatment.name}</b>
    <div class="row">
        <div class="text-muted col-md-6">	
            
        </div>
        <div class="text-right text-muted col-md-6">
            {new moment(th.created_at).format('YYYY-MM-DD HH:mm:ss')}
        </div>
    </div>
    {/if}
</div>

{:else if (($selectedTooths.length == 0) || $toothStates[th.tooth_id].active)}
	
	{#if th.created_at <= $dateInterval[1]}
	<div class="col-md-12 text-left thcontainer" on:click={showHistoryDetail(th)}
	style="cursor: pointer;"
	class:now={th.checkin_id>0}
	class:existing={th.checkin_id == 0}>
	<div class="glyph" style="display: flex; justify-content: flex-end; font-size: 1rem;"
		on:click|stopPropagation={()=>handleDelete(th)}>
        <div class="glyph-icon simple-icon-close"></div>
    </div>
	    <b>{th.tooth_id == 0? 'Бүх шүд':`#${th.tooth_id}`} - {th.treatment.name}</b>
	    <div class="row">
	        <div class="text-muted col-md-6">	
	            {#if th.treatment.id == 1}
			    	<div>{th.tooth_type_id == 1? 'сүүн шүд':''}</div>
			    	<div>цоорол - {th.decay_level}</div>
			    {/if}
	        </div>
	        <div class="text-right text-muted col-md-6">
	            {new moment(th.created_at).format('YYYY-MM-DD HH:mm:ss')}
	        </div>
	    </div>
	</div>
	{/if}

{/if}
<div class="mb-1"></div>
{/each}

<Dialog bind:this={historyDialog}
		style="z-index: 1050;">

	<Title>
		{treatmentHistory.tooth_id == 0? 'Бүх шүд':`Шүд #${treatmentHistory.tooth_id}`}
		 - {treatmentHistory.treatment.name}</Title>
	<Content>
		<TreatmentHistoryDetail 
			{treatmentHistory}/>
		<br>
		{#if treatmentHistory.checkin_id > 0}
			<h4>Шинж тэмдэг</h4>
			<div class="input-group">
				<!-- <div class="input-group-prepend">
					<span class="input-group-text">
						Шинж тэмдэг
					</span>
				</div> -->
				<Textfield autofocus={false} textarea fullwidth bind:value={symptom} label="" input$aria-controls="helper-text-textarea" input$aria-describedby="helper-text-textarea"/>
			</div>
			<div class="mb-3"></div>
			<h4>Онош</h4>
			<div class="input-group">
				
				<!-- <div class="input-group-prepend">
					<span class="input-group-text">
						Онош
					</span>
				</div> -->
				<Textfield autofocus={false} textarea fullwidth bind:value={diagnosis} label="" input$aria-controls="helper-text-textarea" input$aria-describedby="helper-text-textarea" />
			</div>
		{/if}
	</Content>

	<Actions>
		{#if treatmentHistory.checkin_id > 0}
			<button class="btn btn-primary" on:click={handleSave}>Хадгалах</button>
		{:else}
			<Button class="btn btn-primary">Буцах</Button>
		{/if}
	</Actions>

</Dialog>

<Dialog bind:this={deleteDialog}
	style="z-index: 1050;">
	<Title>Эмчилгээ устгах</Title>

	<Content>
		<div>
			{treatmentHistory.tooth_id == 0? 'Бүх шүд':`Шүд #${treatmentHistory.tooth_id}`}
		 - {treatmentHistory.treatment.name}
		</div>
		<TreatmentHistoryDetail 
			{treatmentHistory}/>
	</Content>

	<Actions>
		<Button primary><Label>Болих</Label></Button>
		<Button on:click={() => handleConfirmDelete(treatmentHistory)}><Label>Устгах</Label></Button>
	</Actions>
</Dialog>

<Snackbar bind:this={noteResultSnackbar}>
	<Label>{noteResult}</Label>
</Snackbar>

<script>

	import Dialog, {Title, Content, Actions} from '@smui/dialog';
	import Textfield from '@smui/textfield';
	import HelperText from '@smui/textfield/helper-text/index';
	import Button, {Label} from '@smui/button';
	import {toothStates, 
			treatmentHistories, 
			selectedTooths,
			dateInterval,
			dateIntervals,
			checkin} from './stores/store.js';

	import {deleteUserTreatment, 
			getTreatmentImgSrc,
			addUserTreatment,
			saveNote} from '../api/doctor-treatment-api.js';

	import TreatmentHistoryDetail from './TreatmentHistoryDetail.svelte';

	import Snackbar from '@smui/snackbar';

	import moment from 'moment';


	const handleDelete = (th) => {
		treatmentHistory = th;
		deleteDialog.open();
	}

	const handleConfirmDelete = (th) => {
		deleteUserTreatment(th.id)
			.then(response=>{
				// update ui
				$treatmentHistories = $treatmentHistories.filter(e=>e.id != th.id);
				$dateIntervals = $treatmentHistories.map(t => t.created_at).reverse();
				$toothStates[th.tooth_id].treatments = $toothStates[th.tooth_id].treatments.filter(t => t.created_at !== th.created_at);

				let treatments = $toothStates[th.tooth_id].treatments;
				console.log($toothStates[th.tooth_id]);
				if (treatments.length == 0){
					$toothStates[th.tooth_id].value = 0;
				}else{
					$toothStates[th.tooth_id].value = treatments[treatments.length-1].value;
				}
				$toothStates = $toothStates;
			})
			.catch(err=>{
				console.log(err);
			})
	}

	let historyDialog;
	let deleteDialog;
	let treatmentHistory = {
		tooth_id: 1,
		treatment: {name:''},
		symptom: '',
		diagnosis: ''
	}

	let symptom = '';
	let diagnosis = '';

	let noteResultSnackbar;
	let noteResult = '';

	const showHistoryDetail = (th) => {
		treatmentHistory = th;
		symptom = th.symptom? th.symptom: '';
		diagnosis = th.diagnosis? th.diagnosis: '';
		historyDialog.open();
	}

	const handleSave = () => {
		treatmentHistory.symptom = symptom;
		treatmentHistory.diagnosis = diagnosis;

		let data = {
			id: treatmentHistory.id,
			checkin_id: $checkin.id,
			symptom,
			diagnosis
		}
		console.log('saving', data);
		saveNote(data)
			.then(response => {
				console.log('save note response');
				console.log(response.data);
				noteResult = 'Амжилттай хадгалагдлаа';
				noteResultSnackbar.open();
				historyDialog.close();
			})
			.catch(err => {
				alert('Тэмдэглэл хадгалахад алдаа гарлаа');
				console.log(err);
			})
	}

</script>


<style>

	.topright{
		position: absolute;
		top: 3;
		right: 3;
	}

	.planned{
        border-left: thick solid brown;
    }

    .existing{
        border-left: thick solid orange;
    }

    .now{
        border-left: thick solid #2a7eeb;
    }
</style>