


<div class="col-md-3">
    <div class="card">
        <ul class="nav nav-tabs nav-justified ml-0 mb-2" role="tablist">
            <li class="nav-item" on:click={handleClickHistoryTab}>
                <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
                    aria-controls="first" aria-selected="true">Түүх</a>
            </li>
            <li class="nav-item" on:click={handleClickTreatmentTab}>
                <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
                    aria-controls="second" aria-selected="false">Эмчилгээ</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane show scroll active" id="first" role="tabpanel" aria-labelledby="first-tab">
                <TreatmentHistoryList />
            </div>

            <div class="tab-pane scroll" id="second" role="tabpane2" aria-labelledby="second-tab">
                <Treatments />
            </div>
        </div>
    </div>
    <form>
        {#if tab == 1}
            <br>
            <select class="form-control" name="nurse_id"
                bind:value={$entryMode}>
                <option value={$checkin}>одоо хийх эмчилгээ</option>
                <option value={existing}>өөр эмнэлэгт хийгдсэн эмчилгээ</option>
            </select>
        {:else}
            <PaintTools on:stop={handleStopPaint}/>
        {/if}
        <br>
        <button type="button" class="btn btn-primary btn-block" on:click={()=>finishDialog.open()}>ДУУСГАХ</button>
    </form>
</div>

<Dialog bind:this={finishDialog} aria-labelledby="simple-title" aria-describedby="simple-content">
    <Title>{dialogTitle}</Title>
    <Content>{dialogContent}</Content>
    <Actions>
        <Button><Label>cancel</Label></Button>
        <Button><Label>OK</Label></Button>
    </Actions>
</Dialog>

<Finish bind:dialog={finishDialog}/>

<script>
    import List, {Item, Text} from '@smui/list';
    import Dialog, {Title, Content, Actions} from '@smui/dialog';
    import Button, {Label} from '@smui/button';
    import FormField from '@smui/form-field';
    import Checkbox from '@smui/checkbox';

    import TreatmentHistoryList from './TreatmentHistoryList.svelte';
    import Treatments from './Treatments.svelte';
    import PaintTools from './PaintTools.svelte';
    import {selectedTooths, 
            toothStates,
            selectedTreatment,
            entryMode,
            checkin,
            patient,
            points,
            paintState} from './stores/store.js';
    import Finish from './Finish.svelte';
    import {addPainting} from '../api/doctor-treatment-api';


    export let finishDialog;

    let selected = [];
    // let options = [
    //                 {value: 2, name: 'Би'},
    //                 {value: 4, name: 'Өөр эмч'}
    //             ];
    $: console.log('selected', selected);

    let tab = 0;
    $: $entryMode = $checkin;

    let dialogTitle = 'Dialog Title';
    let dialogContent = 'content';

    let planned = {
        id: 0,
    }

    let existing = {
        id: 0
    }

    const handleClickHistoryTab = () => {
        $selectedTreatment = 0;
        tab = 0;
    }

    const handleClickTreatmentTab = () => {
        tab = 1;
        $paintState.tool = null;
        $paintState.drawing = false;
        $paintState = $paintState;
    }

    const handleStopPaint = () => {
        let paint = {
            user_id: $patient.id,
            content: JSON.stringify($points)
        }
        addPainting(paint)
            .then(response => {
                console.log('stored paint');
                $points = [];
            })
            .catch(err => {
                console.log(err);
            })
    }

    const storePaint = () => {

    }

</script>

<style>

    .treatment-text{
        color: #666666;
    }
</style>