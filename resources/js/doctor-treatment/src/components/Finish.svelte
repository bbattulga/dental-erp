<Dialog bind:this={dialog} aria-labelledby="simple-title" aria-describedby="simple-content"
	style="z-index: 1050;">
    <Title>{dialogTitle}</Title>
    <Content>
    	<table class="table table-bordered table-responsive">
                    <thead class="thead-light">
                        <tr>
                            <td>#</td>
                            <td>Шүд</td>
                            <td>Эмчилгээ</td>
                            <td>Үнэ</td>
                        </tr>
                    </thead>
                    <tbody>
                    	{#each $treatmentHistories as th, i}
                    	{#if $treatmentHistories[i].id == null}
                            <tr>
                            	<td>{i+1}</td>
                            	<td>{th.tooth_id == 0? 'Бүх шүд': th.tooth_id}</td>
                            	<td>{th.treatment.name}</td>
                            	<td>
                            		<div class="input-group">
	                            		<input class="form-control"
	                            			class:invalid={$treatmentHistories[i].price >0 && ($treatmentHistories[i].price < th.treatment.price) || ($treatmentHistories[i].price>th.treatment.limit)}
	                            			on:change={()=>handleValidatePrice(th,$treatmentHistories[i].price)}
	                            			bind:value={$treatmentHistories[i].price}
	                            			required="{true}">
	                            	</div>
                            	</td>
                            </tr>
                        {/if}
                        {/each}
                        <tr>
                        	<td>Нийт</td>
                        	<td colspan={5}>{total}₮</td>
                        </tr>
                    </tbody>
                </table>
    </Content>
    <Actions>
        <Button><Label>cancel</Label></Button>
        <button class="btn btn-primary" on:click={handleFinish}><Label>OK</Label></button>
    </Actions>
</Dialog>
<Snackbar bind:this={resultSnackbar}>
  <Label>Амжилттай хадгалагдлаа - {lastTotal}₮</Label>
  <!-- <Actions>
    <IconButton title="Dismiss">close</IconButton>
  </Actions> -->
</Snackbar>

<script>
    import Dialog, {Title, Content, Actions} from '@smui/dialog';
    import Snackbar from '@smui/snackbar';
    import IconButton from '@smui/icon-button';
    import TreatmentHistoryList from './TreatmentHistoryList.svelte';
    import Button, {Label} from '@smui/button';
    import {treatmentHistories} from './stores/store.js';
    import {addUserTreatment} from '../api/doctor-treatment-api.js';
    import axios from 'axios';


    let resultSnackbar;
    let total = 0;
    let lastTotal = 0;
    $:{
    	total = 0;
    	for (let i=0; i<$treatmentHistories.length; i++){
    		if ($treatmentHistories[i].id == null &&
                $treatmentHistories[i].price)
    			total += parseInt($treatmentHistories[i].price);
    	}
    	total = total.toLocaleString();
    }

    const handleValidatePrice = (treatmentHistory, val) => {
    	let treatment = treatmentHistory.treatment;
    	if (val >= treatment.price && (val<=treatment.limit)){
    		treatmentHistory.price = val;
    	}
    }

    const handleFinish = () => {
    	if (document.getElementsByClassName('invalid').length > 0){
    		alert('Үнэн дүн буруу байна');
    		return true;
    	}
        lastTotal = total;
    	storeTreatments().then(response=>{
    		console.log('storeTreatments response');
    		$treatmentHistories = $treatmentHistories;
    		dialog.close();
    		resultSnackbar.open();
    	})
    }

    const storeTreatments = () => {

    	return new Promise((resolve, reject)=>{
    		let promises = [];
    		for (let i=0; i<$treatmentHistories.length; i++){
    			if ($treatmentHistories[i].id){
    				continue;
    			}
    			let userTreatment = $treatmentHistories[i];
    			let promise = addUserTreatment(userTreatment);
    			promise.then(response=>{
    				console.log('setting id', $treatmentHistories[i].treatment.name);
    				$treatmentHistories[i].id = response;
    			}).catch(err=>{
    				console.log('error when storing history')
    				console.log(err);
    				handleError($treatmentHistories[i]);
    			})
    			promises.push(promise);
    		}
    		 axios.all(promises).then(responses=>{
    		 	resolve(responses);
    		 });
    	});
    }

    const handleError = (userTreatment) => {
    	alert(JSON.stringify(userTreatment));
    }
    export let dialog;
    let dialogTitle = 'Үнэн дүнгүүдийг оруулна уу';
</script>

<style>

	.invalid{
		border: 1px solid red;
	}
</style>