<script>
import Tailan from './components/Tailan.svelte';
import Table from './components/table/Table.svelte';
import axios from 'axios';
import {category_stats, categories} from './stores.js';
import LinearProgress from '@smui/linear-progress';


// here we will create each tailan...

// for legacy code
let startDate = document.getElementById('date-start');
let endDate = document.getElementById('date-end');
let btnShow = document.getElementById('show-datebetween');


let LOADING = false;
const fetchCategoryStats = (startDate, endDate) => {
	LOADING = true;
	let promises = [];
	console.log('sending promises');
	for (let i=0; i<$categories.length; i++){
		let data = {
			category_id: $categories[i].id,
			start_date: startDate,
			end_date: endDate
		};
		console.log('sending');
		console.log(data);
		let promise = axios.post('/api/tailan/treatments/datebetween', data);
		promises.push(promise);
	}
	axios.all(promises).then(responses=>{
		LOADING = false;
		let _category_stats = [];
		for (let i=0; i<responses.length; i++){
			let response = responses[i];
			_category_stats.push(response.data);
		}
		$category_stats = _category_stats;
		console.log('category stats');
		console.log(_category_stats);
	})
}

axios.post('/api/treatment-categories')
	.then(response=>{
		let all = {id: null, name: 'Нийт'};
		$categories = [all, ...response.data];
		console.log('intial categories');
		console.log($categories);
		fetchCategoryStats(startDate.value, endDate.value);
	})
	.catch(err=>{
		console.log(err);
	});

const handleDateChange = (startDate, endDate) => {
	console.log('show date between');
	console.log(startDate, endDate);
	fetchCategoryStats(startDate, endDate);
}

async function fetchCategoryStat(categoryId, startDate, endDate) {

  let data = {
		category_id: $categories[i].id,
		start_date: startDate,
		end_date: endDate
	};

  const rawResponse = await fetch('/api/tailan/treatments/datebetween', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  });
  const result = await rawResponse.json();
  console.log('fetch result');
  console.log(result);
};

btnShow.onclick = () => handleDateChange(startDate.value, endDate.value);

let ages = [];
for (let i=0; i<=16; i++) ages[i] = i;

</script>

<LinearProgress 
	style="position: fixed; top: 0; left: 50%; width: 100%; transform: translateX(-50%); z-index: 1000000;"
	indeterminate
	closed={!LOADING}/>
<!-- <Table {ages} /> -->
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
{/each}