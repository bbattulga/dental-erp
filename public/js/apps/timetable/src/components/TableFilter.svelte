<script type="text/javascript">
	
	import TimeTable from './TimeTable.svelte';
	import {createEventDispatcher} from 'svelte';

	export let shifts = [];
	export let times;
	export let doctors = [];

	const dispatch = createEventDispatcher();


	const dateFormat = (date) => {
		return date.toLocaleDateString('en-CA');
	}

	const addDays = (date, days) => {
		let d = new Date(date);
		d.setDate(d.getDate()+days);
		return d;
	}

	let date = new Date();

	let lastDay = new Date(date.getFullYear(), date.getMonth()+1, 0).getDate();

	let showDoctors = true;

	let dates = [
		{
			name:'Өнөөдөр', 
			selected: true, // optional
			readonly: true, // optional

			period: [
				dateFormat(date)
			]
		},

		{
			name:'Энэ сарын', 
			readonly: true,
			period: [
				dateFormat(addDays(date, -(date.getDate())+1)), 
				dateFormat(addDays(new Date(), lastDay-date.getDate() ))
			]
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

	let selectedDoctor = '*';

	let selectedDate = dates[0];

	const handleSelectDateType = (event) => {
		console.log('selected date ', selectedDate);
		if (selectedDate.period.length > 1)
			selectedDoctor = null;
		else
			selectedDoctor = '*';
		shifts = [];
		handleDateChange();
	}

	const handleSelectDoctor = (event) =>{
		if (selectedDoctor == null)
			return;
		handleDateChange();
	}

	const handleDateChange = (event) => {
		console.log('handleDateChange',selectedDoctor)

		if (selectedDoctor == null){
			console.log('selected doctor null');
			showDoctors = false;
			return;
		}

		showDoctors = true;
		selectedDate = selectedDate;
		if (selectedDate.period.length > 1){
			showDoctors = false;
		}
		console.log('selected doctor: ', selectedDoctor);
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
					<select bind:value={selectedDate} on:change={handleSelectDateType}>
						{#each dates as date}
						<option value={date} selected={date.selected}>{date.name}</option>
						{/each}
					</select>
				</div>
				<div class="col">
					<input on:blur={handleDateChange} type="date" 
							bind:value={selectedDate.period[0]} 
							readonly="{selectedDate.readonly}">
					{#if selectedDate.period.length>1}
					- <input on:blur={handleDateChange} type="date" 
							bind:value={selectedDate.period[1]}
							readonly="{selectedDate.readonly}">
					{/if}
				</div>
			</div>

			<div class="row">
				<label>Эмч</label>
				<select bind:value={selectedDoctor} on:change={handleSelectDoctor}>
					{#if selectedDate.period.length == 1}
					<option value={'*'}>Бүх эмч</option>
					{:else}
					<option value={null} selected>Эмч сонгох</option>
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
		{showDoctors}
		{times}/>

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