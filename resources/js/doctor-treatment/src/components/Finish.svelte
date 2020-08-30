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
                    	{#each $treatmentHistories as th, i (th.id)}

                    	{#if !$treatmentHistories[i].price}
                            <tr transition:fade>
                            	<td>{i+1}</td>
                            	<td>{th.tooth_id == 0? 'Бүх шүд': th.tooth_id}</td>
                            	<td>{th.treatment.name}</td>
                            	<td>
                                    {#if th.checkin_id > 0}
                                		<div class="input-group">
    	                            		<input class="form-control"
                                                placeholder="{th.treatment.price.toLocaleString()}-{th.treatment.limit.toLocaleString()}₮" 
    	                            			class:invalid={th.inputPrice > 0 && (th.inputPrice < th.treatment.price) || (th.inputPrice>th.treatment.limit)}
    	                            			on:change={()=>handleValidatePrice(th, th.inputPrice)}
    	                            			bind:value={th.inputPrice}
    	                            			required="{true}"
                                                type="number">
    	                            	</div>
                                    {:else}
                                        <div>
                                            Өөр эмнэлэгт хийлгэсэн эмчилгээ
                                        </div>
                                    {/if}
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
        <Button><Label>болих</Label></Button>
        <button class="btn btn-primary ml-3" on:click={handleFinish}><Label>Болсон</Label></button>
    </Actions>
</Dialog>
<Snackbar bind:this={resultSnackbar}>
  <Label>Амжилттай хадгалагдлаа - {lastTotal.toLocaleString()}₮</Label>
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
    import {treatmentHistories, 
            checkin,
            patient,
            points,
            paintState} from './stores/store.js';

    import {addUserTreatment, 
            updateUserTreatment,
            finishTreatment,
            addPainting} from '../api/doctor-treatment-api.js';
    import axios from 'axios';

    import {fade} from 'svelte/transition';

    import moment from 'moment';

    export let dialog;
    let dialogTitle = 'Үнэн дүнгүүдийг оруулна уу';


    let resultSnackbar;
    let total = 0;
    let lastTotal = 0;

    $:{
    	total = 0;
    	for (let i=0; i<$treatmentHistories.length; i++){
    		if (!$treatmentHistories[i].price){
                if (!isNaN($treatmentHistories[i].inputPrice))
                    total += parseInt($treatmentHistories[i].inputPrice);
            }
    	 }
    	total = total.toLocaleString();
    }

    const handleValidatePrice = (treatmentHistory, val) => {
        console.log('onchange');
        console.log(val);
    	// let treatment = treatmentHistory.treatment;
    	// if (val >= treatment.price && (val<=treatment.limit)){
    	// 	treatmentHistory.price = val;
    	// }
    }

    const quit = () => {
        window.location = '/doctor';
    }

    const handleSavePainting = () => {
        return new Promise((resolve, reject) => {

            // any left painting?
            if ($points.length == 0){
                resolve(true);
            }
            let data = {
                user_id: $patient.id,
                content: JSON.stringify($points)
            }
            addPainting(data)
                .then(response => {
                    resolve(true);
                })
                .catch(err => {
                    reject(err);
                });
        });
    }

    const handleFinish = () => {
    	if (document.getElementsByClassName('invalid').length > 0){
    		alert('Үнэн дүн буруу байна');
    		return true;
    	}
        lastTotal = total;

        // define async function then call immediately
        const finish = async () => {
            try{
                await handleSavePainting();
            }catch(err){
                if (confirm('Зураг хадгалахад алдаа гарлаа дахиж оролдох уу?')){
                    await handleSavePainting(); // why not xd
                }
            }
            try{
                let responses = await storeTreatments();
                console.log('storeTreatments responses');
                console.log(responses);
                $treatmentHistories = $treatmentHistories;
                resultSnackbar.open();
                dialog.close();
                let checkinRequest = {
                    checkin_id: $checkin.id
                }
                let finishResult = await finishTreatment(checkinRequest);
                if (finishResult.data == 0){
                    alert('Эмчилгээг дуусгахад алдаа гарлаа\nДахиж  оролдоно уу');
                    console.log(err);
                    return;
                }
                setTimeout(quit, 2000);
            }catch(err){
                alert('Эмчилгээнүүдийг хадгалахад алдаа гарлаа\nPage reload хийнэ үү');
                console.log(err);
            }
        }
        finish();
    }

    const storeTreatments = () => {
        // assumes prices are valid

		let promises = [];
        lastTotal = 0;
		for (let i=0; i<$treatmentHistories.length; i++){

            let userTreatment = $treatmentHistories[i];
            // already recorded?
            // on other hospital?
			if ((userTreatment.price > 0) || 
                (userTreatment.checkin_id == 0)){
				continue;
			}
            // new record
            lastTotal += parseInt(userTreatment.inputPrice);
            userTreatment.price = userTreatment.inputPrice;
            console.log('update ut');
            console.log(userTreatment);
			let promise = updateUserTreatment(userTreatment);
			promises.push(promise);
		}
		return axios.all(promises);
    }

    const handleError = (userTreatment) => {
        alert('Үнэн дүн хадгалахад алдаа гарлаа');
        userTreatment.price = null;
    }
    
</script>

<style>

	.invalid{
		border: 1px solid red;
	}
</style>