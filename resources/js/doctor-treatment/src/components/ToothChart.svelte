<div class="col-md-9">
    <div class="card">
        <div style="background-color: white; color: black; 
            display: inline-block; font-size: 2.3em;
            position: absolute; top: 0; right: 0; cursor: pointer;">

            <slot name="topleft"></slot>
        </div>
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
    import {toothStates, selectedTooth, 
        selectedTooths,selectedTreatment} from './stores/store.js';
    import {treatmentHistories} from './stores/store.js';
    import {checkin, patient} from './stores/store.js';
    import TreatmentNoteModal from './TreatmentNoteModal.svelte';
    import DecayChart from './DecayChart.svelte';
    import {onMount, onDestroy} from 'svelte';


    let showDecayChart = false;
    let confirmDialog;
    let allToothDialog;

    const datediff = (first, second) => {
        // Take the difference between the dates and divide by milliseconds per day.
        // Round to nearest whole number to deal with DST.
        return Math.round((second-first)/(1000*60*60*24));
    }

    const handleClickTooth = (event) => {
        let {treatmentId, toothCode} = event.detail;
        $selectedTooth = toothCode;
        let state = $toothStates[toothCode];
        let lastTreatment = state.treatments[state.treatments.length-1];

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
        if (lastTreatment != $selectedTreatment.id){

            // add treatment for selected tooth
            handleAddTreatment(event);
        }
        else{
            if (datediff(new Date(), new Date($selectedTreatment.created_at))>0){
                confirmDialog.open();
                return;
            }
            if ($selectedTreatment.id == 1){
                showDecayChart = true;
                return;
            }
            // same as last treatment
            state.treatments.pop();
            $treatmentHistories.pop();
            $treatmentHistories = $treatmentHistories;
            $toothStates = $toothStates;
        }
    }

    const handleAddTreatment = (event) => {
        let code = event.detail.toothCode;
        console.log('add treatment to ', code);
        let userTreatment = {
            id: null,
            checkin_id: $checkin.id,
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
            created_at: new Date().toLocaleDateString('en-CA')
        }

        let treatment = $selectedTreatment;
        if (treatment.id == 1 && (showDecayChart == false)){
            showDecayChart = true;
            return;
        }
        if (treatment.id == 1 && showDecayChart){
            showDecayChart = false;
        }
        // update tooth ui
        $toothStates[code].treatments.push($selectedTreatment.id);
        console.log('pushed treatment')
        console.log($toothStates[code].treatments);
        $toothStates = $toothStates;

        // update history
        userTreatment.treatment = treatment;
        console.log('adding usertreatment');
        console.log(userTreatment);
        $treatmentHistories = [userTreatment, ...$treatmentHistories];
    }

    const handleDeleteTreatment = () => {

    }
    const range = (a, b) => {

        let list = [];
        for (let i = a; i <= b; i++) {
            list.push(i);
        }
        return list;
    }
</script>