
<script>

	import p5 from 'p5';
	// import {HsvPicker} from 'svelte-color-picker';

	import {paintState,
			paintHistory,
			points} from './stores/store.js';
	import { onMount } from 'svelte';

	let container;
	let rect;

	let drawedAllPoints = false;
	
	// draw poing from description
	const drawPoint = (s, point) => {

		let blendMode;
		if (point.blend_mode === s.REMOVE){
			blendMode = s.REMOVE;
			s.stroke(s.color(0, 0, 0));
		}else{
			blendMode = s.BLEND;
			s.stroke(point.color);
		}
		s.blendMode(blendMode);
		s.strokeWeight(point.weight*$paintState.canvasWidth*$paintState.canvasHeight);
		s.point($paintState.canvasWidth*point.x, $paintState.canvasHeight*point.y);
	}

	// draw brand new point
	const drawNewPoint = (s, x, y) => {

		let blendMode;
		if ($paintState.color === 'eraser'){
			blendMode = s.REMOVE;
			s.stroke('#fff');
		}else{
			blendMode = s.BLEND;
			s.stroke($paintState.color);
		}
		s.blendMode(blendMode);
		
		s.strokeWeight($paintState.weight);

		$points.push({
			x: x/$paintState.canvasWidth,
			y: y/$paintState.canvasHeight,
			weight: $paintState.weight/($paintState.canvasWidth*$paintState.canvasHeight),
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
			s.fill(0,0,0,0); 
		}

		s.mouseDragged = () => {
			if(shouldDraw(s))
				drawNewPoint(s, s.mouseX, s.mouseY);
		}

		s.mouseClicked = () => {
			if (shouldDraw(s))
				drawNewPoint(s, s.mouseX, s.mouseY)
		}
// 
// 			s.draw = () => {
// 				if (!$paintState.drawing){
// 					return false;
// 				}
// 			}

			s.touchStarted = () => {
				if(shouldDraw(s))
					drawNewPoint(s, s.mouseX, s.mouseY);
			}
	}

	// create p5 instances that draw each snapshots
	
	let sketchInstance;
	$:{
		let c = container;
		if (c != null)
			sketchInstance = new p5(sketch);
	}

	$:{
		let ph = $paintHistory;
		console.log('ph changed', ph.length);
		console.log(ph);
		let c = container;
		if (ph.length > 0 && (c != null)){
			console.log('sketch instance');
			console.log(sketchInstance);
			for (let i=0; i<$paintHistory.length; i++){
				let h = $paintHistory[i];
// 				const snapShot = (s) => {
// 
// 					s.setup = () => {
// 						rect = container.getBoundingClientRect();
// 
// 						let canvas = s.createCanvas(rect.width, rect.height);
// 						canvas.parent(container);
// 					}
// 
// 					s.draw = () => {
// 						let points = h.content;
// 						for (let i=0; i<points.length; i++){
// 							drawPoint(s, points[i]);
// 						}
// 					}
// 				}
// 				new p5(snapShot);
				let points = h.content;
				for (let i=0; i<points.length; i++){
					drawPoint(sketchInstance, points[i]);
				}
			}
		}
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