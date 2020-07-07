<script type="text/javascript">
	
	import {fade} from 'svelte/transition';

	import Cell from './Cell.svelte';
	import {createEventDispatcher} from 'svelte';
	import Row from './Row.svelte';

	// contains {doctor, appointments}
	export let shifts = [];

	export let times;
	
</script>


<table 
	class="main-table ">
	<!-- Title columns -->
	<tr class="header-row">
		<td style="text-align: center; z-index: 100000;">Эмч/Цаг</td>
		{#each times as time}
		<th class="time-container">{time}</th>
		{/each}
	</tr>

	{#each shifts as shift (shift.id)}
		<Row 
			{shift}
			{times}/>
	{/each}
</table>


<style>

	table{
		position: relative;
		border-collapse: collapse;
	}

	*{
		font-size: 16px;
		font-weight: 10;
		font-family: Arial sans-serif;
	}

	th{
		z-index: 100000;
		background: white;
		min-width: 150px;
		border: 3px solid #cccccc;
	}

	.time-container{
		text-align: center;
	}

	td, tr, th{
		transition: 0.3s;
		border-collapse: collapse;
		border: 3px solid #cccccc;
	}

	.main-table{
		border: 1px solid #333333;
	}

	.header-row{
		min-width: 100%;
		position: sticky;
		top: 0px;
	}
</style>