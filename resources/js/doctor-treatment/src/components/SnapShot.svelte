

<script>

	import p5 from 'p5';
	// import {HsvPicker} from 'svelte-color-picker';

	import {paintState,
			paintHistory} from './stores/store.js';
	import { onMount } from 'svelte';

	export let points = [];

	export let container;
	onMount(() => {

		const drawPoint = (s, point) => {

			let blendMode;
			if (point.blend_mode === s.REMOVE){
				blendMode = s.REMOVE;
				s.stroke(s.color(0, 0, 0));
			}else{
				blendMode = s.BLEND;
				s.stroke(s.color($paintState.color.r, $paintState.color.g, $paintState.color.b));
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
	});
</script>