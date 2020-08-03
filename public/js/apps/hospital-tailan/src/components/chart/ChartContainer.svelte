<script>

    import {onMount} from 'svelte';
    export let height = '300px';

    let container;
    onMount(()=>{
        container.style.height = height;
    });

</script>



<div bind:this={container} class="chart-container">
	<slot></slot>
</div>