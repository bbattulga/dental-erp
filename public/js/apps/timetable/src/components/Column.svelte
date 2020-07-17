<script type="text/javascript">

	import Cell from './Cell.svelte';

	export let shift;
	export let times = [];

	let appointments = shift.appointments;

	let step = 15;
	let hour = 9;
	let min = 0;
	let maxHour = 20;

	const formatHour = (hour, min) => {
		let hourPrefix = hour<10? '0': '';
		let minPrefix = min<10? '0': '';
		return `${hourPrefix}${hour}:${minPrefix}${min}`;
	}
	console.log(times);

	const calc = (times, appointments) => {

		let cellsData = [];

		for (let i=9; i<=20; i++){

			let time = formatHour(hour, min);
			let appointment = null;
			/*
			// find appointment that matches the time
			for (let i=0; i<appointments.length; i++){
				let appointment = appointments[i];
				if (true){
					continue;
				}

				// calculate appointment's time
				// expects hh:mm
				appointment = appointments[j];
				let sh = appointment.start;
				let eh = appointment.end;
				d = eh - sh;

				// if d>1 then next available time will be i+1 or i+2 or i+timeGap
				i += d-1;
				// found a appointment
				break;
			}
			*/

			// put cell data that will be reported back
			let cellData = {
				shift,
				time,
				appointment,
				rowSpan: 1
			};
			cellsData.push(cellData);
			console.log('time:',formatHour(hour, min));
			min += step;
			if (min == 60){
				hour++;
				min = 0;
			}
		}

		return cellsData;
	}

	let cellsData = [];
	console.log('calc appointment times');
	$: cellsData = calc(times, shift.appointments);
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
		//cellsData = calc(times, appointments);
	}

	const deleteAppointment = (event) => {
		appointments = appointments.filter((a)=>a.id!=event.detail);
	}


	function generateId(cell){
		if (cell.appointment == null)
			return Math.random();
		return `${cell.appointment.id}-${cell.appointment.start}`;
	}
	console.log('screensize');
	$:{console.log(screen.width)}

	const resizeDefault = () => {
		console.log('resize');
	}
</script>


<div>
	<tr><td class="tbl-head">{shift.doctor.name}</td></tr>

	{#each times as time}

		
	
	<div class="cell-container">
		{shift.doctor.name}
		<button on:click={resizeDefault}>resize</button>
	</div>
		
		<!--
		<tr>
			<td>
				{time}
			</td>
		</tr>
		-->
		<!--
		<Cell 
			on:addAppointment={addAppointment}
			on:deleteAppointment={deleteAppointment}
			shift={cellData.shift}
			time={cellData.time}
			appointment={cellData.appointment}
			rowSpan={cellData.rowSpan} /> -->

	{/each}
</div>

<style>

	.column-container{
		display: flex;
		flex-flow: column nowrap;
	}

	.tbl-head{
		height: 80px;
	}

	.cell-container{
		resize: vertical; overflow: hidden;
		height: 50px;
		transition: 0.3s;
	}

</style>