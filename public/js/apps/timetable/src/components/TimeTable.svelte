<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	export let doctors;
	export let customers;
	export let times;

</script>


<table class="main-table">

	<!-- Title columns -->
	<tr class="header-row">
		<td></td>
		{#each doctors as doctor}
		<td>{doctor.name}</td>
		{/each}
	</tr>

	<!-- time rows -->
	{#each times as time}
	<tr>
		<td>{time}:00 цаг</td>

		<!-- add customer cell here -->
		<!-- for each doctors -->
		{#each doctors as doctor}
			<Cell customer={customers.find((c)=>c.doctor_id=doctor.id)}/>
		{/each}
	</tr>
	{/each}
</table>

<style>

	.main-table{
		display: grid;
		background-color: #e7e7e7e7;
	}

	.header-row{
		height: 100px;
		position: sticky;
		top: 0px;
		background-color: #abd6dfff;
	}

	td{
		width: 80px;
		height: 80px;
		padding: 10px;
		border-radius: 3px;
		background-color: white;
		margin: 10px;
	}
</style>