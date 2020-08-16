



<div class="card">
    <div class="card-body">
        <div class="icon-wrapper">
            <div class="glyph" on:click={() => handleClick('pencil')}
            	class:active={selected === 'pencil'}
            	class:inactive={selected !== 'pencil'}>
                <div class="glyph-icon simple-icon-pencil"></div>
            </div>
        </div>

        <div class="icon-wrapper">
	        <div class="glyph" on:click={() => handleClick('eraser')}
	        	class:active={selected === 'eraser'}
            	class:inactive={selected !== 'eraser'}>
	            <div class="glyph-icon iconsmind-Eraser"></div>
	        </div>
	    </div>
	    <Slider displayMarkers
	    	bind:value={weight}
	    	on:change={() => console.log('paint weight slider onchange')}
	    	min={minWeight} max={maxWeight}/>
	    	
	    <div class="row">
			    <div bind:this={colorIndicator} style="width: 30px; height: 30px;"></div>
			    <div class="mr-2"></div>
			    <button on:click|preventDefault={() => showColorPicker=true}>өнгө сонгох</button>
		</div>
	    {#if showColorPicker}
		    <div class="colorpicker">
		    	<div class="glyph" style="display: flex; justify-content: flex-end; font-size: 1.5rem; 
		    						cursor: pointer; margin-bottom: 2px;"
					on:click|preventDefault={() => showColorPicker=false}>
			        <div class="glyph-icon simple-icon-close"></div>
			    </div>
			    <HsvPicker on:colorChange={handleChangeColor} 
			    	startColor={rgbToHex($paintState.color.r, $paintState.color.g, $paintState.color.b)}/>
			</div>
		 {/if}
    </div>
</div>


<script>

	import {paintState} from './stores/store.js';
	import {HsvPicker} from 'svelte-color-picker';
	import Slider from '@smui/slider';
	import p5 from 'p5';

	import {rgbToHex} from './lib.js';


	let selected;
	let minWeight = 3;
	let maxWeight = 100;
	let weight = 10;

	let colorIndicator;
	let showColorPicker = false;

	$:{
		$paintState.weight = weight;
		$paintState = $paintState;
	}

	$:{
		let currentColor = $paintState.color;
		let hex = currentColor === 'eraser'? '#fff':rgbToHex(currentColor.r, currentColor.g, currentColor.b);
		if (colorIndicator)
			colorIndicator.style.backgroundColor = hex;
	}
	const draw = () => {
		if ($paintState.color === 'eraser'){
			$paintState.color = {r: 10, g: 11, b: 12}
			$paintState = $paintState
		}
	}

	const handleChangeColor = (event) => {
		let rgb = event.detail;
		$paintState.color = rgb;
		$paintState = $paintState;
	}

	const handleClick = (key) => {
		if (selected === key){
			selected = null;
			$paintState.drawing = false;
			$paintState = $paintState;
			return;
		}
		$paintState.drawing = true;
		$paintState = $paintState;
		selected = key;
		switch(key){
			case 'pencil':
				draw();
				break;
			case 'eraser':
				$paintState.color = 'eraser';
				$paintState = $paintState;
				break;
		}
	}

</script>

<style>

	.icon-wrapper{
        display: inline-block; 
        font-size: 2.3rem;
        cursor: pointer;
	}

	.active{
		opacity: 1;
		color: #2a7eeb;
	}

	.inactive{
		opacity: 0.4;
	}

	.colorpicker{
		position: fixed;
		bottom: 0;
		right: 0;
		transform: translate(-50%, -50%);
		margin: 10px;
	}
</style>