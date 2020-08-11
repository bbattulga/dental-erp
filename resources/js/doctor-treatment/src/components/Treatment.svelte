<Item on:click={()=>handleClickTreatment(treatment)}
	on:blur={()=>console.log('onblur')}>
	{#if treatment.id == 1}
	    <Text class="treatment-text" data-toggle="modal" data-target="#decayChartModal" >
	        {treatment.name}
	    </Text>
    {:else}
    	<Text class="treatment-text">
	        {treatment.name}
	    </Text>
    {/if}
</Item>


<script>
	export let treatment;

</script>