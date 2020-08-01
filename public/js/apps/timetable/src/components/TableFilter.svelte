<script type="text/javascript">
	
	import TimeTable from './TimeTable.svelte';
	import SearchInput from './SearchInput.svelte';
	import {createEventDispatcher} from 'svelte';
	import {fade} from 'svelte/transition';
	import {onDestroy} from 'svelte';
	import {storeShifts, storeDoctors, storeTimes, storeSearch} from '../stores/stores.js';

	import Tab, {Label, Icon} from '@smui/tab';
	import TabBar from '@smui/tab-bar';
	import List from './List.svelte';


	const dispatch = createEventDispatcher();

	let shifts = [];
	$:{console.log('shifts changed in Tablefilter.svelte',shifts)}
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
	const handleSearch = (value) => {
		storeSearch.update(old=>value);
	}

	const handleStopSearch = (value) => {
		console.log('stop search');
		storeSearch.update(old=>null);
	}

	let searchInput = document.getElementById('dore-admin-search');
	const handleSearchChange = (event) => {
		let val = searchInput.value;
		console.log(val);
		if (val.length == 0){
			handleStopSearch(val);
			return;
		}
		handleSearch(val);
	}
	searchInput.onkeyup = handleSearchChange

	onDestroy(()=>{
		unsubscribeSearch();
		unsubscribeTimes();
		unsubscribeDoctors();
		unsubscribeShifts();
	});

	let tabs = ['Цаг', 'Жагсаалт', 'Төлөвлөсөн'];
	let active;
</script>


<div 
	class="main-div">
	<!--
	 <SearchInput 
			on:search={handleSearch}
			on:stopsearch={handleStopSearch}/> -->
	<div>
		<TabBar {tabs} let:tab bind:active>
	      <!-- Notice that the `tab` property is required! -->
	      <Tab {tab}>
	      	<Icon class="material-icons"></Icon>
	        <Label>{tab}</Label>
	      </Tab>
	    </TabBar>
	    <!--
	    <SearchInput 
			on:search={handleSearch}
			on:stopsearch={handleStopSearch}/>
		-->
	</div>

	{#if active === tabs[0]}
	<TimeTable
		{shifts}
		{times}/>
	{:else if active == tabs[1]}
		<List
			{shifts}
			{times}/>
	{/if}

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