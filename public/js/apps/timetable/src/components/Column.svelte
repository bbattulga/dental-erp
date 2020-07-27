<script type="text/javascript">

	import Cell from './Cell.svelte';
	import {onMount} from 'svelte';
	import {timeToFloat, floatToTime} from '../lib/datetime.js';

	export let shift;
	export let times = [];

	export let colWidth = '10%';
	let appointments = [];
	$: appointments = shift.appointments;
	
	let step = 15;
	let hour = 9;
	let min = 0;
	let maxHour = 20;

	const calc = (times, appointments) => {
		let cellsData = [];

		for (let i=0; i<times.length; i++){
			let time = times[i];
			let rowSpan = 1;
			let appointment = null;

			for (let j=0; j<appointments.length; j++){
				if (timeToFloat(appointments[j].start) == time.float){
					appointment = appointments[j];
					let start = timeToFloat(appointment.start);
					let end = timeToFloat(appointment.end);
					let d = end - start;
					if (d <= 0){
						d = 0.5;
						break;
					}
					rowSpan = d/0.5;
					break;
				}
			}
			// put cell data that will be reported back
			let cellData = {
				id: appointment? appointment.id:{},
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
	$: cellsData = calc(times, appointments);
	//console.log('calc appointment times done');

		const handleCellClick = (event) => {
		console.log('row handle click');
	}

	const addAppointment = (event) => {
		let appointment = event.detail;
		console.log('adding new appointment ', appointment);
		if (appointment)
			appointments = [...appointments, appointment];
		cellsData = calc(times, appointments);
	}

	const deleteAppointment = (event) => {
		appointments = appointments.filter((a)=>a.id!=event.detail);
	}

	const refresh = (event) => {
		console.log('refresh');
		cellsData = calc(times, appointments);
	}

	let container = null;
	onMount(()=>{	
		container.style.width = colWidth;
	});

</script>

<div bind:this={container} class="column-container">

	<div class="doctor-profile">
		{`${shift.doctor.last_name.charAt(0)+'. '+shift.doctor.name}`}
	</div>

	{#each cellsData as cellData, i (cellData.id)}
		<Cell
			index={i}
			on:addAppointment={addAppointment}
			on:deleteAppointment={deleteAppointment}
			on:forceRefresh={refresh}
			appointment={cellData.appointment}
			nodes={cellsData}
			width={colWidth}
			rowSpan={cellData.rowSpan}
			time={cellData.time}
			{shift} />
	{/each}
</div>

<style>


	.column-container {
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
	  background-color: white;
	  color: #e0e0e0e0;
	  border-right: 1px solid #e0e0e0e0;
	  border-bottom: 1px solid #e0e0e0e0;
	  border-top: 1px solid #e0e0e0e0;
	  background-color: #0c2546;
	  color: white;
	  font-size: 1.5vh;
	  font-weight: 600;
	  text-align: center;
	  line-height: 8vh;
	  height: 8vh;
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