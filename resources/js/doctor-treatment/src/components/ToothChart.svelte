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
                        <td><Filling /></td>
                        {/each}
                        {#each range(21, 28) as tc}
                        <td><Filling /></td>
                        {/each}
                    </tr>
                    <tr>
                        {#each range(31, 38) as tc}
                        <td><Filling value={12} /></td>
                        {/each}
                        {#each range(41, 48) as tc}
                        <td><Filling /></td>
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
<DecayChart bind:show={showDecayChart} />

<script>
    import {getToothCodes, getTreatmentImgSrc, addUserTreatment} from '../api/doctor-treatment-api.js';
    import Dialog, {Title, Content, Actions} from '@smui/dialog';
    import Button, {Label} from '@smui/button';
    import Tooth from './Tooth.svelte';
    import Filling from './Filling.svelte';
    import {toothStates, selectedTooth, selectedTreatment} from './stores/store.js';
    import {treatmentHistories} from './stores/store.js';
    import {checkin, patient} from './stores/store.js';
    import TreatmentNoteModal from './TreatmentNoteModal.svelte';
    import DecayChart from './DecayChart.svelte';


    let showDecayChart = false;
    let toothCodes = getToothCodes();
    $toothStates = new Array(48);
    for (let i=0; i<toothCodes.length; i++){
        let state = {
            treatmentId: null,
            code: toothCodes[i],
            active: true,
            imgSrc: getTreatmentImgSrc(toothCodes[i], null)
        }
        $toothStates[toothCodes[i]] = state;
    }
    $toothStates = $toothStates;
    const handleClickTooth = (event) => {
        let {treatmentId, toothCode} = event.detail;
        $selectedTooth = toothCode;
        let state = $toothStates[toothCode];
        if (!$selectedTreatment){
            return;
        }

        if (state.treatmentId != $selectedTreatment.id){
            handleAddTreatment(event);
        }
        else{
            // same as last treatment

        }
    }

    const handleAddTreatment = (event) => {
        let code = event.detail.toothCode;

        let userTreatment = {
            id: null,
            checkin_id: $checkin.id,
            user_id: $checkin.user_id,
            treatment_id: $selectedTreatment.id,
            treatment: null,
            treatment_selection_id: 0,
            treatment_selection: null,
            tooth_id: code,
            price: null,
            symptom: '',
            diagnosis: '',

            value: 0,
            decay_level: 0,
            tooth_type_id: 0,
            created_at: new Date().toLocaleDateString('en-CA')
        }

        let treatment = $selectedTreatment;
        if (treatment.id == 1){
            showDecayChart = true;
            return;
        }
        addUserTreatment(userTreatment)
            .then(response=>{
                // update tooth ui
                let imgSrc = getTreatmentImgSrc(code, $selectedTreatment.id);
                $toothStates[code].imgSrc = imgSrc;
                $toothStates[code].treatmentId = $selectedTreatment.id;
                $toothStates = $toothStates;

                // update history
                userTreatment.id = response;
                userTreatment.treatment = treatment;
                console.log('adding usertreatment');
                console.log(userTreatment);
                $treatmentHistories = [userTreatment, ...$treatmentHistories];
            });
    }
    const range = (a, b) => {

        let list = [];
        for (let i = a; i <= b; i++) {
            list.push(i);
        }
        return list;
    }
</script>