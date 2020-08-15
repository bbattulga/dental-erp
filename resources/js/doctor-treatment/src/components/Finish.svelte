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
                    	{#if typeof $treatmentHistories[i].id !== 'number'}
                            <tr transition:fade>
                            	<td>{i+1}</td>
                            	<td>{th.tooth_id == 0? 'Бүх шүд': th.tooth_id}</td>
                            	<td>{th.treatment.name}</td>
                            	<td>
                                    {#if th.checkin_id > 0}
                                		<div class="input-group">
    	                            		<input class="form-control"
                                                placeholder="{th.treatment.price.toLocaleString()}-{th.treatment.limit.toLocaleString()}₮" 
    	                            			class:invalid={$treatmentHistories[i].price >0 && ($treatmentHistories[i].price < th.treatment.price) || ($treatmentHistories[i].price>th.treatment.limit)}
    	                            			on:change={()=>handleValidatePrice(th,$treatmentHistories[i].price)}
    	                            			bind:value={$treatmentHistories[i].price}
    	                            			required="{true}">
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
    import {treatmentHistories, checkin} from './stores/store.js';
    import {addUserTreatment, finishTreatment} from '../api/doctor-treatment-api.js';
    import axios from 'axios';

    import {fade} from 'svelte/transition';

    import moment from 'moment';


    let resultSnackbar;
    let total = 0;
    let lastTotal = 0;
    $:{
    	total = 0;
    	for (let i=0; i<$treatmentHistories.length; i++){
    		if (typeof $treatmentHistories[i].id !== 'number' &&
                ($treatmentHistories[i].price != null)){
                total += parseInt($treatmentHistories[i].price);
            }
    	}
    	total = total.toLocaleString();
    }

    const handleValidatePrice = (treatmentHistory, val) => {
    	let treatment = treatmentHistory.treatment;
    	if (val >= treatment.price && (val<=treatment.limit)){
    		treatmentHistory.price = val;
    	}
    }

    const quit = () => {
        window.location = '/doctor';
    }

    const handleFinish = () => {
    	if (document.getElementsByClassName('invalid').length > 0){
    		alert('Үнэн дүн буруу байна');
    		return true;
    	}
        lastTotal = total;
    	storeTreatments().then(axios.spread((...responses)=>{
            console.log('storeTreatments response');
            console.log(responses);
            $treatmentHistories = $treatmentHistories;
            resultSnackbar.open();
            dialog.close();
            let data = {
                checkin_id: $checkin.id
            }
            finishTreatment(data)
                .then(response => {
                    if (response.data == 0){
                        alert('Эмчилгээг дуусгахад алдаа гарлаа\nДахиж  оролдоно уу');
                        console.log(err);
                        return;
                    }
                    setTimeout(() => {quit()}, 2000);
                })
                .catch(err => {
                    alert('Эмчилгээг дуусгахад алдаа гарлаа\nДахиж  оролдоно уу');
                });
        })).catch(err=>{
            alert('Эмчилгээнүүдийг хадгалахад алдаа гарлаа\nPage reload хийнэ үү');
            console.log(err);
        })
    }

    const storeTreatments = () => {
		let promises = [];
        lastTotal = 0;
		for (let i=0; i<$treatmentHistories.length; i++){

            // already recorded?
			if (typeof $treatmentHistories[i].id === 'number'){
				continue;
			}

            console.log('sending');
            console.log($treatmentHistories[i]);

            if ($treatmentHistories[i].price != null)
                lastTotal += parseInt($treatmentHistories[i].price);

            // new record
			let userTreatment = $treatmentHistories[i];
            console.log('storing');
            console.log(userTreatment);
            userTreatment.price = userTreatment.price == null? 0:userTreatment.price;
			let promise = addUserTreatment(userTreatment)
			 .then(response => {
				$treatmentHistories[i] = response.data;
                $treatmentHistories[i].created_at = new moment($treatmentHistories[i].created_at)
                                                            .format('YYYY-MM-DD HH:mm:ss');
			}).catch(err=>{
				console.log('error when storing history')
				console.log(err);
				handleError($treatmentHistories[i]);
			})
			promises.push(promise);
		}
		return axios.all(promises);
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