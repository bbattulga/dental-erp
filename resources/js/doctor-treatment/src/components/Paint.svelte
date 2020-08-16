<script>

	import p5 from 'p5';
	// import {HsvPicker} from 'svelte-color-picker';

	import {paintState,
			paintHistory} from './stores/store.js';
	import { onMount } from 'svelte';

	let container;

	let points = [];

	onMount(() => {

		const drawPoint = (s, x, y) => {

			let blendMode;
			if ($paintState.color === 'eraser'){
				blendMode = s.REMOVE;
				s.stroke(s.color(0, 0, 0));
			}else{
				blendMode = s.BLEND;
				s.stroke(s.color($paintState.color.r, $paintState.color.g, $paintState.color.b));
			}
			s.blendMode(blendMode);
			
			s.strokeWeight($paintState.weight);

			points.push({
				x,
				y,
				weight: $paintState.weight,
				blend_mode: blendMode,
				color: $paintState.color
			});
			s.point(x, y);
		}

		const sketch = (s) => {

			let colorPicker;
			s.setup = () => {
				let rect = container.getBoundingClientRect();
				let canvas = s.createCanvas(rect.width, rect.height);
				canvas.parent(container);
			}

			s.mouseDragged = () => {
				if($paintState.drawing)
					drawPoint(s, s.mouseX, s.mouseY);
			}

			s.touchStarted = () => {
				if($paintState.drawing)
					drawPoint(s, s.mouseX, s.mouseY);
			}

			s.mouseReleased = () => {
				for (let i=0; i<points.length; i++) $paintHistory.push(points[i]);
			}

			s.touchEnded = () => {
				for (let i=0; i<points.length; i++) $paintHistory.push(points[i]);
			}
		}

		const sketchInstance = new p5(sketch);
	});

	const handleColorChange = (rgba) => {
		console.log(rgba.detail);
	}
</script>


<div bind:this={container} class="paint-container"
	class:front={$paintState.drawing}
	class:penone={!$paintState.drawing}>
</div>

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