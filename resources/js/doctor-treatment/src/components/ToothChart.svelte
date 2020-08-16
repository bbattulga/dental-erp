<div class="col-md-9">
    <div class="card">

        <Paint />
                    
        
        <div class="card-body mb-2">
            <div class="table-responsive">
                <table class="table text-center">

                    <tr>
                        {#each range(11, 18) as tc}
                        <td>{tc}</td>
                        {/each}
                        {#each range(21, 28) as tc}
                        <td>{tc}</td>
                        {/each}
                    </tr>
                    <tr>
                        {#each range(11, 18) as tc}
                        <td>
                            <Tooth on:click={handleClickTooth} 
                                toothCode={tc}/>
                        </td>
                        {/each}
                        {#each range(21, 28) as tc}
                        <td>
                            <Tooth on:click={handleClickTooth} 
                                toothCode={tc}/>
                        </td>
                        {/each}
                    </tr>
                    <tr>
                        {#each range(11, 18) as tc}
                        <td><Filling toothCode={tc} /></td>
                        {/each}
                        {#each range(21, 28) as tc}
                        <td><Filling toothCode={tc} /></td>
                        {/each}
                    </tr>
                    <tr>
                        {#each range(31, 38) as tc}
                        <td><Filling toothCode={tc} value={12} /></td>
                        {/each}
                        {#each range(41, 48) as tc}
                        <td><Filling toothCode={tc} /></td>
                        {/each}
                    </tr>
                    <tr>
                        {#each range(31, 38) as tc}
                        <td>{tc}</td>
                        {/each}
                        {#each range(41, 48) as tc}
                        <td>{tc}</td>
                        {/each}
                    </tr>
                    <tr>
                        {#each range(31, 38) as tc}
                        <td>
                            <Tooth on:click={handleClickTooth}
                                toothCode={tc}/>
                        </td>
                        {/each}
                        {#each range(41, 48) as tc}
                            <td>
                                <Tooth on:click={handleClickTooth}
                                    toothCode={tc}/>
                            </td>
                        {/each}
                    </tr>
                </table>
            </div>
        </div>
        <div class="m-3">
            <div>Хугацаа <br>
                {$dateInterval[0]} - 
                {$dateInterval[1]}
            </div>
            <Slider bind:value={svalue}
                min={0} max={$dateIntervals.length>0?$dateIntervals.length-1:0} step={1} discrete displayMarkers />
        </div>

        <div class="card-footer">
            <slot name="footer"></slot>
        </div>
    </div>
</div><!-- Tooth images ending-->
<DecayChart on:submit={handleAddTreatment} bind:show={showDecayChart} />

<!-- same treatment or trying to delete treatment -->
<Dialog bind:this={confirmDialog} aria-labelledby="event-title" aria-describedby="event-content" 
    on:MDCDialog:closed={()=>console.log('close')}
    style="z-index: 1050;">
  <Title id="event-title">Эмчилгээ өмнө нь хийгдсэн байна</Title>
  <Content id="event-content">
    Шүд #{$selectedTooth} - {$selectedTreatment.name}
  </Content>
  <Actions>
    <Button action="none">
      <Label>Эмчилгээ устгах</Label>
    </Button>
    <Button action="all" default>
      <Label>Давтан эмчилгээ</Label>
    </Button>
  </Actions>
</Dialog>

<script>
    import Dialog, {Title, Content, Actions} from '@smui/dialog';
    import Button, {Label} from '@smui/button';
    import Tooth from './Tooth.svelte';
    import Filling from './Filling.svelte';
    import Paint from './Paint.svelte';

    import {toothStates, 
            selectedTooth, 
            selectedTooths,
            selectedTreatment,
            entryMode,
            dateInterval,
            dateIntervals,
            paintState} from './stores/store.js';

    import { addUserTreatment } from '../api/doctor-treatment-api.js';

    import {treatmentHistories} from './stores/store.js';
    import {checkin, patient} from './stores/store.js';
    import DecayChart from './DecayChart.svelte';
    import {onMount, onDestroy} from 'svelte';

    import Slider from '@smui/slider';

    import moment from 'moment';


    let showDecayChart = false;
    let confirmDialog;
    let allToothDialog;

    let svalue = -1;

    $:{
        let intervals = $dateIntervals;
        console.log('dateIntervals changed');
        if (intervals.length > 0){
            $dateInterval[0] = intervals[0];
            $dateInterval[1] = intervals[intervals.length - 1];
            if (svalue < 0){
                console.log('interval changed');
                console.log(svalue);
                svalue = intervals.length - 1;
                console.log(svalue);
            }
        }
        if (!$dateIntervals[svalue]) svalue--;
    }
    $:{
        let th = $treatmentHistories;
        console.log('th changed');
        //svalue = th.length - 1;
    }
    $:{
        let index = svalue;
        $dateInterval[1] = $dateIntervals[index]?$dateIntervals[index]:new moment().format('YYYY-MM-DD');
    }

    const datediff = (first, second) => {
        // Take the difference between the dates and divide by milliseconds per day.
        // Round to nearest whole number to deal with DST.
        return Math.round((second-first)/(1000*60*60*24));
    }

    const handleClickTooth = (event) => {

        if ($paintState.drawing)
            return;

        let {treatmentId, toothCode} = event.detail;
        $selectedTooth = toothCode;
        let state = $toothStates[toothCode];
        let lastTreatment = state.treatments[0];

        // clicked without selecting treatment
        if (!$selectedTreatment){

            if ($selectedTooths.includes(toothCode)){
                $selectedTooths = $selectedTooths.filter(e=>e!=toothCode);
            }else{
                $selectedTooths.push(toothCode);
            }
            console.log($selectedTooths);
            $toothStates[toothCode].active = !$toothStates[toothCode].active;
            if ($selectedTooths.length == 0){
                for (let i=11; i<=48; i++){
                    if (!$toothStates[i]) continue;
                    $toothStates[i].active = true;
                }
            }
            else{
                for (let i=11; i<=48; i++){
                    if (!$toothStates[i]) continue;
                    if ($selectedTooths.includes(i))
                        $toothStates[i].active = true;
                    else{
                        $toothStates[i].active = false;
                    }
                }
            }
            $toothStates = $toothStates;
            return;
        }

        // clicked with treatment
        let lastTreatmentId = lastTreatment? lastTreatment.treatment.id:null;
        if (lastTreatmentId != $selectedTreatment.id){

            // add treatment for selected tooth
            handleAddTreatment(event);
        }
        else{
            // same as last treatment
            console.log('delete treatment');

            // if it is current date, then delete that else 
            // may ask like that treatment again?
            if (datediff(new Date(), new Date($selectedTreatment.created_at))>0){
                handleAddTreatment(event);
                return;
            }

            // may re-lombo
            if ($selectedTreatment.id == 1){
                showDecayChart = true;
                return;
            }
            // same as last treatment
            $dateIntervals.pop();
            $dateIntervals = $dateIntervals;
            state.treatments.shift();
            $treatmentHistories.shift();
            $treatmentHistories = $treatmentHistories;
            $toothStates = $toothStates;
        }
    }

    const handleAddTreatment = (event) => {
        let code = event.detail.toothCode;
        console.log('add treatment ', $selectedTreatment);

        let treatment = $selectedTreatment;
        if (treatment.id == 1 && (showDecayChart == false)){
            showDecayChart = true;
            return;
        }
        if (treatment.id == 1 && showDecayChart){
            showDecayChart = false;
        }
        let userTreatment = {
            id: {}, // typeof .id === 'number' to do actions...
            checkin_id: $entryMode.id,
            user_id: $checkin.user_id,
            treatment_id: $selectedTreatment.id,
            treatment: $selectedTreatment,
            treatment_selection_id: 0,
            treatment_selection: null,
            tooth_id: code,
            price: null,
            symptom: '',
            diagnosis: '',
            value: $toothStates[code].value,
            decay_level: $toothStates[code].decayLevel,
            tooth_type_id: $toothStates[code].toothTypeId,
            created_at: new moment().format('YYYY-MM-DD HH:mm:ss')
        }
        // update tooth ui
        $toothStates[code].treatments.unshift(userTreatment);
        $dateIntervals = [...$dateIntervals, userTreatment.created_at];
        svalue = $dateIntervals.length - 1;
        $toothStates = $toothStates;

        // update history
        $treatmentHistories = [userTreatment, ...$treatmentHistories];
    }

    const range = (a, b) => {

        let list = [];
        for (let i = a; i <= b; i++) {
            list.push(i);
        }
        return list;
    }
</script>