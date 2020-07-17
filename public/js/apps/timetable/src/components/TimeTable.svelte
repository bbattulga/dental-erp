<script type="text/javascript">

	import Cell from './Cell.svelte';
	import Column from './Column.svelte';


	// contains {doctor, appointments}
	export let shifts = [];
	console.log('timetable got shifts', shifts);
	export let times;
	
	export let showDoctors = true;


</script>


<div
	class="main-table ">
	<table>
		<tr><td class="tbl-head">Эмч/Цаг</td></tr>
		{#each times as time}
			<tr>
				<td>
					{time}
				</td>
			</tr>
		{/each}
	</table>
	{#each shifts as shift (`${shift.id}${showDoctors}`)}
		<Column 
			{shift}
			{times}/>
	{/each}
</div>


<style>

	.tbl-head{
		height: 80px;
	}
	td{
		height: 50px;
		transition: 0.3s;
		border-collapse: collapse;
		border: 3px solid #cccccc;
	}

	.main-table{
		display: grid;
		grid-auto-flow: column;
	}

		.doctor-icon{
		width: 100px;
		height: 100px;
	}

	.doctor-icon img{
		max-width: 100%;
		height: auto;
	}
</style>