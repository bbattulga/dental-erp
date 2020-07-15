<script type="text/javascript">

	import Cell from './Cell.svelte';
	import Row from './Row.svelte';

	// contains {doctor, appointments}
	export let shifts = [];
	console.log('timetable got shifts', shifts);
	export let times;
	
	export let showDoctors = true;

</script>


<table 
	class="main-table ">
	<!-- Title columns -->
	<tr class="header-row">
		<td style="text-align: center; z-index: 100000;">{showDoctors? 'Эмч/Цаг':'Өдөр/Цаг'}</td>
		{#each times as time}
		<td class="time-container"><p>{time}</p></td>
		{/each}
	</tr>

	{#each shifts as shift (`${shift.id}${showDoctors}`)}
		<Row 
			{shift}
			{times}>

			<div slot="th">

			{#if showDoctors}
			<div class="doctor-icon">
				<img name="th-icon" src="/js/apps/timetable/src/components/assets/doctor.png">
			</div>

			<h4>
				{shift.doctor.name}
			</h4> 
			<!-- end if showDoctors -->
			{:else}
				{shift.date}
			{/if}
		</div>
		</Row>
	{/each}
</table>


<style>

	table{
		position: relative;
		border-collapse: collapse;
		line-height: 50px;
		border: 3px solid #cccccc;
	}

	*{
		font-size: 16px;
		font-weight: 10;
		font-family: Arial sans-serif;
	}

	.time-container{
		z-index: 100000;
		background: white;
		width: 10%;
		border: 3px solid #cccccc;
	}

	.time-container > p{
		text-align: center;
		background: white;
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
		border: 3px solid #cccccc;
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