<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import axios from 'axios';


	// EXPECTS TIME FORMATS AS hh:mm

	export let shift;
	let shift_id = shift.id;
	let doctor = shift.doctor;
	let appointments = shift.appointments;

	export let times = [];


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

	const calc = (times, appointments) => {

		let cellsData = [];
		for (let i=0; i<times.length; i++){

			let time = times[i];

			// find user of time
			let appointment = null;

			let d = 1;
			for (let j=0; j<appointments.length; j++){


			let prefix = (appointments[j].start<10)? '0': '';

				if (prefix+appointments[j].start+":00" != time){
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

			// put cell data that will be reported back
			let cellData = {
				shift,
				time,
				appointment
			};
			cellsData.push(cellData);
		}
		return cellsData;
	}

	let cellsData = [];
	$: cellsData = calc(times, appointments);

	function generateId(cell){
		if (cell.appointment == null)
			return Math.random();
		return cell.appointment.id;
	}
</script>


<tr class="main-row">
	<th class="th-doctor">
		<div class="doctor">
			<slot name="th"></slot>
			<slot></slot>
		</div>
	</th>
	{#each cellsData as cellData (generateId(cellData))}
		<Cell 
			on:addAppointment={addAppointment}
			on:deleteAppointment={deleteAppointment}
			shift={cellData.shift}
			time={cellData.time}
			appointment={cellData.appointment}/>
	{/each}
</tr>

<style type="text/css">

	.main-row{

	}

	.th-doctor{
		position: sticky;
		left:0;
		z-index: 2;
	}

	.doctor{

		background-color: white;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		margin: 5px;
	}

	th{
		border: 3px solid #cccccc;
		min-height: 80px;
	}

	td{
		border: 3px solid #cccccc;
	}

	tr{
		border: 3px solid #cccccc;
		height: 100%;
	}
</style>