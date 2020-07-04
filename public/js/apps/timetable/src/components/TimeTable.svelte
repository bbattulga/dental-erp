<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import {createEventDispatcher} from 'svelte';
	import Modal from './modal/Modal.svelte';
	import Row from './Row.svelte';

	export let appointments;
	export let times;
	
</script>


<table class="main-table">
	<!-- Title columns -->
	<tr class="header-row">
		<td></td>
		{#each times as time}
		<th>{time} цаг</th>
		{/each}
	</tr>

	{#each appointments as appointment}
		<Row 
			{times}
			{appointment} />
	{/each}
</table>


<style>

	th{
		width: 200px;
	}

	.main-table{

		background-color: #e7e7e7e7;
		overflow: auto;
		border: 1px solid black;
	}

	.header-row{
		height: 100px;
		min-width: 100%;
		position: sticky;
		top: 0px;
		background-color: #abd6dfff;
	}
</style>