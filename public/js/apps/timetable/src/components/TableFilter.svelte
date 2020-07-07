<script type="text/javascript">
	
	import TimeTable from './TimeTable.svelte';
	import {createEventDispatcher} from 'svelte';
	import moment from 'moment';

	export let shifts;
	export let times;

	const dispatch = createEventDispatcher();


	const dateFormat = (date) => {
		return date.toLocaleDateString('en-CA');
	}

	const addDays = (date, days) => {
		let d = new Date(date);
		d.setDate(d.getDate()+days);
		return d;
	}

	let m = moment();

	let date = new Date();

	let lastDay = new Date(date.getFullYear(), date.getMonth()+1, 0).getDate();

	let dates = [
	{name:'Өнөөдөр', 
	selected: true,
	readonly: true,

	period: [
		dateFormat(date)
		]},
		{
			name:'Энэ сарын', 
			period: [
			dateFormat(addDays(date, -(date.getDate())+1)), 
			dateFormat(addDays(new Date(), lastDay-date.getDate() ))]
		},

		{
			name: 'Өдөр сонгох',
			period: [dateFormat(addDays(date, 1))]
		},

		{
			name: 'Хугацаа сонгох',
			period: [dateFormat(addDays(date,1)), dateFormat(addDays(date, 31))]
		}
	];

	let selectedDoctor;

	// get doctors
	let doctors = shifts.map(shift=>shift.doctor);
	//$:{doctors = shifts.map(shift=>shift.doctor);}

	let selectedDate = dates[0];

	const handleSelect = (event) => {
		if (selectedDoctor == null){
			console.log('selected doctor null');
			return;
		}
			selectedDate = selectedDate;
		handleDateChange();
	}

	const handleDateChange = (event) => {

		let detail = {
			doctor: selectedDoctor,
			date: selectedDate.period
		}
		dispatch('selectDate', detail);
	}

</script>


<div class="main-div">

	<div class="filter-container">
		<div class="filter-container-select">

			<div class="date-container">
				<div class="row">
					<label>Өдөр</label>
					<select bind:value={selectedDate} on:change={handleSelect} on:blur={handleSelect}>
						{#each dates as date}
						<option value={date} selected={date.selected}>{date.name}</option>
						{/each}
					</select>
				</div>
				<div class="col">
					<input on:blur={handleDateChange} type="date" bind:value={selectedDate.period[0]} readonly="{selectedDate.readonly}">
					{#if selectedDate.period.length>1}
					- <input on:blur={handleDateChange} type="date" bind:value={selectedDate.period[1]}>
					{/if}
				</div>
			</div>

			<div class="row">
				<label>Эмч</label>
				<select bind:value={selectedDoctor} on:change={handleSelect} on:blur={handleSelect}>
					{#if selectedDate.period.length == 1}
					<option value={'*'}>Бүх эмч</option>
					{:else}
					<option value={null} selected="{true}">Эмч сонгох</option>
					{#each doctors as doctor}
					<option value={doctor}>{doctor.name}</option>
					{/each}
					{/if}
				</select>
			</div>
		</div>	
	</div>

	<TimeTable
	bind:shifts={shifts}
	{times} />

</div>


<style type="text/css">
	
	input{
		color: black;
	}

	.main-div{
		position: relative;
		color: black;
	}

	.filter-container{
		position: relative;
		display: inline-block;
		margin: 10px;
	}

	.filter-container-select{
		display: flex;	
		position: sticky;
		left: 0;
	}

	.date-container{
		margin-right: 10px;
	}

	.row{
		margin: 10px;
		display: flex;
		flex-direction: column;
		overflow: hidden;
	}

	.col{

	}
</style>