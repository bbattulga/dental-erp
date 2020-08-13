
<div id="decayModal"
    bind:this={lm} class="modal text-center" tabindex="-1" role="dialog"
    class:show
    on:click|self={close}
    transition:fade={{duration: 200}}>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
        <br>
        <br>
        <h3><b>
                <div>Шүд #{$selectedTooth}</div>
            </b></h3>
        <svg height="200" width="200">
            <polygon id="pol-0" 
                class:lombo={flags[4] !== '0'}
                on:click={()=>handleClickDecay(0)} points="0,0 100,100 200,0" />
            <polygon id="pol-1" 
                class:lombo={flags[3] !== '0'}
                on:click={()=>handleClickDecay(1)} points="100,100 200,0 200,200" />
            <polygon id="pol-2" 
                class:lombo={flags[2] !== '0'}
                on:click={()=>handleClickDecay(2)} points="0,200 100,100 200,200" />
            <polygon id="pol-3" 
                class:lombo={flags[1] !== '0'}
                on:click={()=>handleClickDecay(3)} points="0,0 100,100 0,200" />
            <circle id="pol-4" 
                class:lombo={flags[0] !== '0'}
                on:click={()=>handleClickDecay(4)} cx="100" cy="100" r="50" />
        </svg>
        <div>
            <br>
            <h5 style="color: darkgrey"><b>Цоорлын зэрэг</b></h5>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <input type="hidden" id="radioDecayLevel" value="1">
                <label class="btn btn-info active" on:click={()=>decayLevel=1}>
                    <input type="radio" name="decayLevel" id="option1" checked> 1
                </label>
                <label class="btn btn-info" on:click={()=>decayLevel=2}>
                    <input type="radio" name="decayLevel" id="option2"> 2
                </label>
                <label class="btn btn-info" on:click={()=>decayLevel=3}>
                    <input type="radio" name="decayLevel" id="option3"> 3
                </label>
                <label class="btn btn-info" on:click={()=>decayLevel=4}>
                    <input type="radio" name="decayLevel" id="option4"> 4
                </label>
            </div>
        </div>
        <br>
        <h5 style="color: darkgrey"><b>Сүүн шүд</b></h5>
        <label class="switch">
            <input type="checkbox" on:change={()=>isMilky=(isMilky+1)%2}>
            <span class="slider round"></span>
        </label>
        <br>
        <br>
    <button class="btn btn-info btn-ls" on:click={handleSubmit}>ОРУУЛАХ</button>
</div>
</div>
</div>
</div>

<script>

    import Dialog, {Title, Content, Actions} from '@smui/dialog';
    import Button, {Label} from '@smui/button';
    import {fly,fade} from 'svelte/transition';

    import {selectedTooth, toothStates} from './stores/store.js';

    import {createEventDispatcher} from 'svelte';
    export let show = false;
    export let value = 0;

    const dispatch = createEventDispatcher();

    let dialog;
    let decayLevel = 1;
    let isMilky = 0;

    let lm;
    $:console.log('decay modal ', show);
    $:console.log('is milky', isMilky);
    $:console.log('decay level', decayLevel);

    $:{
        if (lm){

            if(show){
                lm.style.display = 'block';
                lm.style.backgroundColor = 'rgba(0, 0, 0, 0.4)';
            }else{
                lm.style.display = 'none';
            }
        }
    }

    const close = (event) => {
        value = 0;
        show = false;
    }

    const toBinList = (base10) => {
        let b = base10.toString(2);
        while (b.length < 5){
            b = '0' + b ;
        }
        return b.split('');
    }
    let flags = new Array(5).fill('0');
    $: flags = toBinList(value);
    // $:{
    //     if ($selectedTooth && $toothStates.length > 0){
    //         value = $toothStates[$selectedTooth].value;
    //         flags = toBinList($toothStates[$selectedTooth].value);
    //         console.log('decaychart react');
    //         console.log(flags);
    //     }
    // }

    const handleClickDecay = (p) => {
        console.log('fill ', p);
        let val = Math.pow(2, p);
        let pol = document.getElementById(`pol-${p}`);
        if (pol.classList.contains('lombo')){
            value -= val;
        }else{
            value += val;
        }
       $toothStates[$selectedTooth].value = value;
       $toothStates = $toothStates;
    }

    const handleSubmit  = () => {

        let detail = {
            toothCode: $selectedTooth,
            decayLevel,
            toothTypeId: isMilky
        }
        value = 0;
       $toothStates[$selectedTooth].decayLevel = decayLevel;
       $toothStates[$selectedTooth].toothTypeId = isMilky;
        dispatch('submit', detail);
    }

</script>


<style>

    .fill{
        fill: #138496;
        animation-duration: 0.3s;
    }

</style>