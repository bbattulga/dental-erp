
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
                <div id="buriLombo">Шүд #{$selectedTooth}</div>
            </b></h3>
        <input type="hidden" id="hiddenDecayChart" value="">
        <svg height="200" width="200">
            <polygon id="pol-0" on:click={()=>handleClickDecay(0)} points="0,0 100,100 200,0" />
            <polygon id="pol-1" on:click={()=>handleClickDecay(1)} points="100,100 200,0 200,200" />
            <polygon id="pol-2" on:click={()=>handleClickDecay(2)} points="0,200 100,100 200,200" />
            <polygon id="pol-3" on:click={()=>handleClickDecay(3)} points="0,0 100,100 0,200" />
            <circle id="pol-4" on:click={()=>handleClickDecay(4)} cx="100" cy="100" r="50" />
        </svg>
        <div>
            <br>
            <h5 style="color: darkgrey"><b>Цоорлын зэрэг</b></h5>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <input type="hidden" id="radioDecayLevel" value="1">
                <label class="btn btn-info active">
                    <input type="radio" name="decayLevel" id="option1" checked> 1
                </label>
                <label class="btn btn-info">
                    <input type="radio" name="decayLevel" id="option2"> 2
                </label>
                <label class="btn btn-info">
                    <input type="radio" name="decayLevel" id="option3"> 3
                </label>
                <label class="btn btn-info">
                    <input type="radio" name="decayLevel" id="option4"> 4
                </label>
            </div>
        </div>
        <br>
        <h5 style="color: darkgrey"><b>Сүүн шүд</b></h5>
        <label class="switch">
            <input type="checkbox" id="suunShudToggle">
            <span class="slider round"></span>
        </label>
        <br>
        <br>
    <button class="btn btn-info btn-ls">ОРУУЛАХ</button>
</div>
</div>
</div>
</div>

<script>

    import Dialog, {Title, Content, Actions} from '@smui/dialog';
    import Button, {Label} from '@smui/button';
    import {fly,fade} from 'svelte/transition';

    import {selectedTooth} from './stores/store.js';

    import {createEventDispatcher} from 'svelte';
    import JQuery from 'jquery';


    let dialog;

    export let show = false;
    let lm;
    $:console.log('decay modal ', show);
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
        show = false;
    }

    let value = 0;
    const handleClickDecay = (p) => {
        console.log('fill ', p);
        let pol = document.getElementById(`pol-${p}`);
        if (pol.style.fill.length > 0){
            pol.style.fill = '';
            return;
        }
        pol.style.fill = '#138496';
    }

</script>


<style>

    .fill{
        fill: #138496;
        animation-duration: 0.3s;
    }

</style>