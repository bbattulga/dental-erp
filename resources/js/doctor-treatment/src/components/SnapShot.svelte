

<div bind:this={container} class="paint-container"
	class:front={$paintState.drawing}
	class:penone={!$paintState.drawing}>
</div>

<script>

	import p5 from 'p5';
	// import {HsvPicker} from 'svelte-color-picker';

	import {paintState,
			paintHistory} from './stores/store.js';
	import { onMount } from 'svelte';

	export let points = [];

	let container;
	onMount(() => {

		const drawPoint = (s, point) => {

			let blendMode;
			if (point.blend_mode === s.REMOVE){
				blendMode = s.REMOVE;
				s.stroke(s.color(0, 0, 0));
			}else{
				blendMode = s.BLEND;
				s.stroke(s.color(0, 0, 0));
			}
			s.blendMode(blendMode);
			s.strokeWeight(point.weight);
			s.point(point.x, point.y);
		}

		const sketch = (s) => {

			let colorPicker;
			s.setup = () => {
				let rect = container.getBoundingClientRect();
				let canvas = s.createCanvas(rect.width, rect.height);
				canvas.parent(container);
			}

			s.draw = () => {
				for (let i=0; i<points.length; i++){
					drawPoint(s, points[i]);
				}
			}
		}

		const sketchInstance = new p5(sketch);
	});
</script>


<style>

	.paint-container{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}

	.penone{
		pointer-events: none;
	}
	/*.behind{
		z-index: -1;
	}
	*/

	.front{
		z-index: 1029;
	}

</style>