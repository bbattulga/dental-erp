<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import {createEventDispatcher} from 'svelte';
	import Row from './Row.svelte';

	// contains {doctor, appointments}
	export let doctorShifts = [];

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

	{#each doctorShifts as shift}
		<Row 
			shift_id={shift.id}
			doctor={shift.doctor}
			appointments={shift.appointments} 
			{times}/>
	{/each}
</table>


<style>

	table{
		border-collapse: collapse;
		border: 1px solid black;
	}

	*{
		font-size: 16px;
		font-weight: 10;
		font-family: Arial sans-serif;
	}

	th{
		width: 200px;
	}

	td, tr, th{
		transition: 0.3s;
		padding: 5px;
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