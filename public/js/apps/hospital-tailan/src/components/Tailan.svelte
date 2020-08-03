<script>

	import {themeColor1, themeColor2, themeColor1_10, themeColor2_10} from './chart/Chart.svelte';
	import ChartContainer from './chart/ChartContainer.svelte';
	import Chart from './chart/Chart.svelte';
	import List from './list/List.svelte';
	import ListItem from './list/ListItem.svelte';

	export let title = '';
	export let total = 0;
	export let total_male = 0;
	export let total_female = 0;
	export let first = 0;
	export let again = 0;
	export let female_ages = [];
	export let male_ages = [];
	export let category_name = '';

	let chart_datasets = [{
	                label: "эрэгтэй",
	                borderColor: themeColor1,
	                backgroundColor: themeColor1_10,
	                data: male_ages,
	                borderWidth: 2,
	              },
	              {
	                label: "эмэгтэй",
	                borderColor: themeColor2,
	                backgroundColor: themeColor2_10,
	                data: female_ages,
	                borderWidth: 2,
	              }];

	// temporary function that gives name for ListItem
	// like 0-4 нас эрэгтэй
	const rowTitle = (ageKey) => {
		return `${ageKey*4}-${(ageKey+1)*4} нас`;
	}

</script>

<div class="row">
	<div class="col-md-6">
        <div class="card">
            <div class="card-body">
            	<h5>{title}</h5>
            	<List>
            		<ListItem name={'Үзлэгийн тоо бүгд'} count={total}/>
            		<ListItem name={'эрэгтэй'} count={total_male}/>
            		<ListItem name={'эмэгтэй'} count={total_female}/>
            		<ListItem name={'анхан'} count={first}/>
            		<ListItem name={'давтан'} count={again}/>
	            	{#each male_ages as male, i}
	            		<ListItem name={rowTitle(i)+' эрэгтэй'} count={male}/>
	            		<ListItem name={rowTitle(i)+' эмэгтэй'} count={female_ages[i]}/>
	            	{/each}
            	</List>
            </div>
        </div>
    </div>
	<div class="col-md-6">
        <div class="card">
            <div class="card-body">
            	<h5>{title}</h5>
				<ChartContainer height={'600px'}>
					<div class="mb-4"></div>
					<Chart type={"horizontalBar"}
						datasets={chart_datasets}/>
				</ChartContainer>
			</div>
		</div>
	</div>
</div>