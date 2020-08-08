<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="overflow: auto;">
            <div class="card-body">
                <table id="treatment-tailan-table" class="table table-striped table-bordered table-responsive" cellspacing="0"
                       width="100%">
                    <thead>
                    	<tr>
                    		<th>Эмчилгээний төрөл</th>
	              			<th>Эмчилгээний төрөл/Нас</th>
	              			{#each ages as age}
	              			<th>
	              				{rowTitle(age)}
	              			</th>
	              			{/each}
	              		</tr>
                    </thead>

                    <tbody>
                    	{#each $categories as category}
                    		{#each subcategories as sub, i}
                    			<tr>
                    				{#if i == 0}
                    				<td rowspan="{subcategories.length}">{category.name}</td>
                    				{:else}
                    				<td style="display: none;"></td>
                    				{/if}
                    				<td>{sub}</td>
                    				{#each ages as age}
                    				<td>{age}</td>
                    				{/each}
                    			</tr>
                    		{/each}
                    	{/each}
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<script>
	import JQuery from 'jquery';
	import DataTables from 'datatables.net';
	import DataTablesButtons from 'datatables.net-buttons';
	import html5btn from 'datatables.net-buttons/js/buttons.html5.js';
	import flashbtn from 'datatables.net-buttons/js/buttons.flash';
	import colvisbtn from 'datatables.net-buttons/js/buttons.colVis';
	import printbtn from 'datatables.net-buttons/js/buttons.print';
	import {category_stats, categories} from '../../stores.js';

	export let ages = [];
	export let subcategories = ['нийт', 'эрэгтэй', 'эмэгтэй', 'анхан', 'давтан'];

	$:{
		ages = [...ages, 'Нийт']
	}
	const rowTitle = (ageKey) => {
		if (Number.isInteger(ageKey))
			return `${ageKey*4}-${(ageKey+1)*4} нас`;
		return ageKey;
	}

	JQuery(document).ready(function(){
		JQuery.noConflict(true);
		DataTables(window, JQuery);
		DataTablesButtons(window, JQuery);
		html5btn(window, JQuery);
		flashbtn(window, JQuery);
		colvisbtn(window, JQuery);
		printbtn(window, JQuery);

		let temp = $category_stats;
		let table = JQuery('#treatment-tailan-table').DataTable({
			dom: 'Bfrtip',
			lengthChange: false,
			ordering: false,
	        buttons: [
	        			'copy', 'excel', 'csv', 'print',
	        			{
			                extend: 'pdf',
			                orientation: 'landscape',
			                pageSize: 'LEGAL'
			            }
	        		]
		});

		$:{
			let ora = $category_stats;
			table.destroy();
			table = JQuery('#treatment-tailan-table').DataTable({
			dom: 'Bfrtip',
			lengthChange: false,
			ordering: false,
	        buttons: [
	        			'copy', 'excel', 'csv', 'print',
	        			{
			                extend: 'pdf',
			                orientation: 'landscape',
			                pageSize: 'LEGAL'
			            }
	        		]
		});
		}
		

	 table.buttons().container()
	        .appendTo('#treatment-tailan-table .col-md-12:eq(0)');

	})
	

</script>