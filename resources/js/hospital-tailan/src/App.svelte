<script>
import Tailan from './components/Tailan.svelte';
import axios from 'axios';
import {category_stats, categories} from './stores.js';
import LinearProgress from '@smui/linear-progress';


// here we will create each tailan...


//let LOADING = false;

// function definitions
const fetchCategories = () => {
	return axios.post('/api/treatment-categories');
}

function fetchCategoryStat(categoryId, startDate, endDate) {

	console.log('fetching');
  let data = {
		category_id: categoryId,
		start_date: startDate,
		end_date: endDate
	};

  return axios.post('/api/tailan/treatments/datebetween', data);
};

// run scripts
// for legacy code
let startDate = document.getElementById('date-start');
let endDate = document.getElementById('date-end');
let btnShow = document.getElementById('show-datebetween');

btnShow.onclick = () => handleDateChange(startDate.value, endDate.value);
let ages = [];
for (let i=0; i<=16; i++) ages[i] = i;

let promise = fetchCategories();
const handleDateChange = (startDate, endDate) => {
	console.log('show date between');
	console.log(startDate, endDate);
	$categories = $categories;
}

fetchCategories()
	.then(response=>{
	handleCategoriesResponse(response);
})
.catch(err=>alert(err));

const handleCategoriesResponse = (response) => {
	let all = {id: null, name: 'Нийт'};
	$categories = [all, ...response.data];
	console.log('categories reloaded');
	console.log($categories);
}

</script>

<!-- <LinearProgress 
	style="position: fixed; top: 0; left: 50%; width: 100%; transform: translateX(-50%); z-index: 1000000;"
	indeterminate
	closed={!LOADING}/> -->

{#each $categories as category, i}
	{#await fetchCategoryStat(category.id, startDate.value, endDate.value)}
		<p>{category.name} - уншиж байна...</p>
		{:then response}
			<Tailan
				title={category.name}
				total={response.data.count_total}
				first={response.data.count_first}
				again={response.data.count_again}
				total_male={response.data.count_male}
				total_female={response.data.count_female}
				male_ages={response.data.age_male}
				female_ages={response.data.age_female}/>
			<div class="mb-5"></div>
	{/await}
{/each}

<!-- 
{#each $category_stats as stat, i ({})}
	<Tailan
		title={$categories[i].name}
		total={stat.count_total}
		first={stat.count_first}
		again={stat.count_again}
		total_male={stat.count_male}
		total_female={stat.count_female}
		male_ages={stat.age_male}
		female_ages={stat.age_female}/>
	<div class="mb-5"></div>
{/each} -->