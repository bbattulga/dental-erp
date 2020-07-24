<script type="text/javascript">
	
	import TimeTable from './TimeTable.svelte';
	import SearchInput from './SearchInput.svelte';
	import {createEventDispatcher} from 'svelte';
	import {fade} from 'svelte/transition';
	import {onDestroy} from 'svelte';
	import {storeShifts, storeDoctors, storeTimes, storeSearch} from '../stores/stores.js';

	const dispatch = createEventDispatcher();

	let shifts = [];
	$:{console.log('shifts changed',shifts)}
	const unsubscribeShifts = storeShifts.subscribe(val=>shifts=val);

	let doctors = [];
	const unsubscribeDoctors = storeDoctors.subscribe(val=>doctors=val);

	let times = [];
	let unsubscribeTimes = storeTimes.subscribe(val=>times=val);

	let searchVal = null;
	let unsubscribeSearch = storeSearch.subscribe(val=>searchVal);

	const dateFormat = (date) => {
		return date.toLocaleDateString('en-CA');
	}

	const addDays = (date, days) => {
		let d = new Date(date);
		d.setDate(d.getDate()+days);
		return d;
	}

	let date = new Date();
	let dateInput = document.getElementById('input-date-selected');
	const handleDateChange = (event) => {
		let detail = {
			date: [dateInput.value]
		}
		dispatch('selectDate', detail);
	}
	dateInput.onchange = handleDateChange;

	// notifies to cells
	const handleSearch = (event) => {
		let value = event.detail.value;
		storeSearch.update(old=>value);
	}

	const handleStopSearch = (event) => {
		console.log('stop search');
		storeSearch.update(old=>null);
	}

	onDestroy(()=>{
		unsubscribeSearch();
		unsubscribeTimes();
		unsubscribeDoctors();
		unsubscribeShifts();
	});
</script>


<div 
	class="main-div">

	<div class="filter-container">
		<SearchInput 
			on:search={handleSearch}
			on:stopsearch={handleStopSearch}/>
	</div>

	<TimeTable
		{shifts}
		{times}/>

</div>


<style type="text/css">

	
	
	input{
		color: black;
	}

	.main-div{
		display: flex;
		flex-direction: column;
		position: relative;
		width: 100%;
		min-height: 100%;
	}

	.filter-container{
		display: flex;
		flex-direction: row;
		align-content: space-between;
		position: relative;
		width: 100%;
		height: 100%;
		margin: 10px;
	}


	.date-container{
		margin-right: 10px;
		width: 100%;
	}

	.row{
		margin: 10px;
		display: flex;
		flex-direction: column;
	}

	.col{

	}
</style>