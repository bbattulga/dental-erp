<script type="text/javascript">

	import Cell from './Cell.svelte';
	import {onMount} from 'svelte';

	export let shift;
	export let times = [];

	export let colWidth = '10%';
	$:console.log('column shift changed', shift);
	let appointments = null;
	$: appointments = shift.appointments;
	
	let step = 15;
	let hour = 9;
	let min = 0;
	let maxHour = 20;

	const formatHour = (hour, min=0) => {
		let hourPrefix = hour<10? '0': '';
		let minPrefix = min<10? '0': '';
		return `${hourPrefix}${hour}:${minPrefix}${min}`;
	}

	const calc = (times, appointments) => {

		let cellsData = [];

		for (let i=0; i<times.length; i++){

			let time = times[i];
			let rowSpan = 1;
			let appointment = null;

			for (let j=0; j<appointments.length; j++){
				if (formatHour(appointments[j].start) == time){
					appointment = appointments[j];
					rowSpan = appointment.end - appointment.start;
					break;
				}
			}
			// put cell data that will be reported back
			let cellData = {
				shift,
				time,
				rowSpan,
				appointment
			};
			i += rowSpan-1;
			cellsData.push(cellData);
		}

		return cellsData;
	}

	let cellsData = [];
	console.log('calc appointment times');
	$: cellsData = calc(times, appointments);
	//console.log('calc appointment times done');

	function handleSubmit(event){

	}

		const handleCellClick = (event) => {
		console.log('row handle click');
	}

	const addAppointment = (event) => {
		let appointment = event.detail;
		console.log('adding new appointment ', appointment);
		appointments = [...appointments, appointment];
		cellsData = calc(times, appointments);
	}

	const deleteAppointment = (event) => {
		appointments = appointments.filter((a)=>a.id!=event.detail);
	}

	let container = null;
	onMount(()=>{	
		container.style.width = colWidth;
	});

	function generateId(appointment){
		if (appointment)
			return appointment.id;
		return Math.random();
	}

</script>

<div bind:this={container} class="day">

	<div class="doctor-profile">
		{`doctor${shift.doctor.id}`}
	</div>

	{#each cellsData as cellData (generateId(cellData.appointment))}
		<Cell
			on:addAppointment={addAppointment}
			on:deleteAppointment={deleteAppointment}
			appointment={cellData.appointment}
			width={colWidth}
			rowSpan={cellData.rowSpan}
			time={cellData.time}
			{shift} />
	{/each}
</div>

<style>


	.day {
		position: relative;
	  width: 10%;
	  height: 100%;
	  float: left;
	  background-size: 1px 20%;
	 /*  z-index: 1030; */
	}

	.doctor-profile {
		/*
		position: sticky;
		top: 0;
	  height: 10%;*/
	  background-color: #1e2749;
	  font-size: 1.5vh;
	  font-weight: 600;
	  text-transform: uppercase;
	  text-align: center;
	  line-height: 10vh;
	  word-wrap: wrap;
	}


	.class {
	  width: 100%;
	  height: 15%; /*90min*/
	  background-color: magenta;
	  font-size: 2vw;
	  font-weight: 300;
	}

</style>