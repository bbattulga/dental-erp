
<script>
    import Moveable from "svelte-moveable";
    import {onMount} from 'svelte';
    import {createEventDispatcher} from 'svelte';

    export let threshold = 24;

    export let height = '100%';
    export let width = '100%';

    const resizeStart = ({ detail: {target, set, setOrigin, dragStart }}) => {
        // Set origin if transform-orgin use %.
        setOrigin(["%", "%"]);

        // If cssSize and offsetSize are different, set cssSize. (no box-sizing)
        const style = window.getComputedStyle(target);
        const cssWidth = parseFloat(style.width);
        const cssHeight = parseFloat(style.height);
        set([cssWidth, cssHeight]);

        // If a drag event has already occurred, there is no dragStart.
        dragStart && dragStart.set(frame.translate);
    }

    const resize = ({ detail: { target, width, height, drag }}) => {

    	let pxWidth = `${width}px`;
    	let pxHeight = `${height}px`;

        target.style.width = pxWidth;
        target.style.height = pxHeight;
        dispatch('resize', {width: pxWidth, height: pxHeight});

        // get drag event
        frame.translate = drag.beforeTranslate;
        target.style.transform
            = `translate(${drag.beforeTranslate[0]}px, ${drag.beforeTranslate[1]}px)`;
    }

    const resizeEnd = ({ detail: { target, isDrag, clientX, clientY }}) => {
        console.log("onResizeEnd", target, isDrag);
    }


    const dispatch = createEventDispatcher();


    const frame = {
        translate: [0, 0],
    };
    let target;

    onMount(()=>{
    	target.style.height = height;
    	console.log('resizer height', height);
    	target.style.width = width;
    })
</script>


<div class="target" bind:this={target}><slot></slot></div>
<Moveable
    target={target}
    resizable={true}
    throttleResize={0}
    on:resizeStart={resizeStart}
    on:resize={resize}
    on:resizeEnd={resizeEnd}

    draggable={true}
    throttleDrag={0}
    on:dragStart={({ detail: { set } }) => {
        set(frame.translate)
    }}
    
    on:drag={({ detail: { target, beforeTranslate }}) => {
        frame.translate = beforeTranslate;
        target.style.transform
            = `translate(${beforeTranslate[0]}px, ${beforeTranslate[1]}px)`;
    }}
    on:dragEnd={({ detail: { target, isDrag, clientX, clientY }}) => {
        console.log("onDragEnd", target, isDrag);
    }}
/>



<style>

</style>