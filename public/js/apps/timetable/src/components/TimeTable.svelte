<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import {createEventDispatcher} from 'svelte';
	import Row from './Row.svelte';

	// contains {doctor, appointments}
	export let shifts = [];

	export let times;
	
</script>


<table class="main-table ">
	<!-- Title columns -->
	<tr class="header-row">
		<td></td>
		{#each times as time}
		<th>{time} цаг</th>
		{/each}
	</tr>

	{#each shifts as shift}
		<Row 
			{shift} 
			{times}/>
	{/each}
</table>


<style>

	table{
		border-collapse: collapse;
	}

	*{
		font-size: 16px;
		font-weight: 10;
		font-family: Arial sans-serif;
	}

	th{
		width: 200px;
		border: 3px solid #cccccc;
	}

	td, tr, th{
		transition: 0.3s;
		border-collapse: collapse;
		border: 3px solid #cccccc;
	}

	.main-table{
		overflow: auto;
		border: 1px solid #333333;
	}

	.header-row{
		height: 100px;
		min-width: 100%;
		position: sticky;
		top: 0px;
	}
</style>