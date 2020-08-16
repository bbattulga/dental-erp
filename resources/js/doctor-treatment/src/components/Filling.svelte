<svg height="25" width="25">
    <polygon id="pl-0" points="0,0 12.5,12.5 25,0"
        class:lombo={flags[4] !== '0'} />
    <polygon id="pl-1" points="12.5,12.5 25,0 25,25"
        class:lombo={flags[3] !== '0'} />
    <polygon id="pl-2" points="0,25 12.5,12.5 25,25"
        class:lombo={flags[2] !== '0'} />
    <polygon id="pl-3" points="0,0 12.5,12.5 0,25"
        class:lombo={flags[1] !== '0'} />
    <circle id="pl-4" cx="12.5" cy="12.5" r="6.25"
        class:lombo={flags[0] !== '0'} />
</svg>



<script>
    import {toothStates} from './stores/store.js';


    export let toothCode;
	export let value = 0;

    const toBinList = (base10) => {
        let b = base10.toString(2);
        while (b.length < 5){
            b = '0' + b ;
        }
        return b.split('');
    }

    let flags = [];
    $:{
        let ts = $toothStates;
        flags = toBinList($toothStates[toothCode].value);
    }

</script>

<style>

.lombo {
        fill: #138496;
        animation-duration: 0.3s;
    }
    
polygon {
    margin: auto;
    display: block;
    stroke-width: 1;
    stroke: darkgrey;
    fill: transparent;
}

circle {
    stroke-width: 1;
    stroke: darkgrey;
    fill: white;
}


</style>