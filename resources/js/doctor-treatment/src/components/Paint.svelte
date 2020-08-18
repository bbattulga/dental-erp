<script>

	import p5 from 'p5';
	// import {HsvPicker} from 'svelte-color-picker';

	import {paintState,
			paintHistory,
			points} from './stores/store.js';
	import { onMount } from 'svelte';

	let container;
	let rect;

	onMount(() => {

		// draw poing from description
		const drawPoint = (s, point) => {

			let blendMode;
			if (point.blend_mode === s.REMOVE){
				blendMode = s.REMOVE;
				s.stroke(s.color(0, 0, 0));
			}else{
				blendMode = s.BLEND;
				s.stroke(s.color(point.color.r, point.color.g, point.color.b));
			}
			s.blendMode(blendMode);
			s.strokeWeight(point.weight);
			s.point(point.x, point.y);
		}

		// draw brand new point
		const drawNewPoint = (s, x, y) => {

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

			$points.push({
				x,
				y,
				weight: $paintState.weight,
				blend_mode: blendMode,
				color: $paintState.color
			});
			s.point(x, y);
		}

		const shouldDraw = (s) => {
			if (!$paintState.drawing)
				return false;
			if ((s.mouseX < 0) || (s.mouseX > rect.width))
				return false;
			if ((s.mouseY < 0) || (s.mouseY > rect.height))
				return false;
			return true;
		}

		const sketch = (s) => {

			let colorPicker;
			s.setup = () => {
				rect = container.getBoundingClientRect();
				$paintState.canvasWidth = rect.width;
				$paintState.canvasHeight = rect.height;
				let canvas = s.createCanvas(rect.width, rect.height);
				canvas.parent(container);
			}

			s.mouseDragged = () => {
				if(shouldDraw(s))
					drawNewPoint(s, s.mouseX, s.mouseY);
			}

			s.mouseClicked = () => {
				if (shouldDraw(s))
					drawNewPoint(s, s.mouseX, s.mouseY)
			}

			s.draw = () => {
				if (!$paintState.drawing){
					return false;
				}
			}

			s.touchStarted = () => {
				if(shouldDraw(s))
					drawNewPoint(s, s.mouseX, s.mouseY);
			}

			s.mouseReleased = () => {
				for (let i=0; i<$points.length; i++) $paintHistory.push($points[i]);
			}

			s.touchEnded = () => {
				for (let i=0; i<$points.length; i++) $paintHistory.push($points[i]);
			}
		}

		const snapShot = (s) => {

			s.setup = () => {
				let rect = container.getBoundingClientRect();
				$paintState.canvasWidth = rect.width;
				$paintState.canvasHeight = rect.height;

				let canvas = s.createCanvas(rect.width, rect.height);
				canvas.parent(container);
			}

			s.draw = () => {
				// draw when not drawing new point
				if ($paintState.drawing){
					return;
				}
				for (let i=0; i<$points.length; i++){
					drawPoint(s, $points[i]);
				}
			}

			s.mouseDragged = () => {
				if(shouldDraw(s))
					drawNewPoint(s, s.mouseX, s.mouseY);
			}

			s.mouseClicked = () => {
				if (shouldDraw(s))
					drawNewPoint(s, s.mouseX, s.mouseY)
			}

			s.touchStarted = () => {
				if(shouldDraw(s))
					drawNewPoint(s, s.mouseX, s.mouseY);
			}
		}

		const sketchInstance = new p5(sketch);
		const snapShotInstance = new p5(snapShot);
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