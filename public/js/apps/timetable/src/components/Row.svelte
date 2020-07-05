<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import axios from 'axios';


	// EXPECTS TIME FORMATS AS hh:mm

	export let shift;
	let shift_id = shift.id;
	let doctor = shift.doctor;
	let appointments = shift.appointments;

	export let times;

	function handleSubmit(event){

	}

	function calc(times, appointments){

		let cellsData = [];
		for (let i=0; i<times.length; i++){

			let time = times[i];

			// find user of time
			let appointment = null;

			let d = 1;
			for (let j=0; j<appointments.length; j++){

				if (""+appointments[j].start+":00" != time){
					continue;
				}

				// calculate appointment's time
				// expects hh:mm
				appointment = appointments[j];
				console.log(appointment.name+' match '+time);
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

	const handleCellClick = (event)=> {
		console.log('row handle click');
	}

	const addAppointment = (event)=> {
		let appointment = event.detail;
		console.log('adding new appointment ', appointment);
		appointments = [...appointments, appointment];
		//cellsData = calc(times, appointments);
	}

	const deleteAppointment = (event)=>{
		appointments = appointments.filter((a)=>a.id!=event.detail);
	}

	let cellsData = [];
	$: cellsData = calc(times, appointments);

	function generateId(cell){
		if (cell.appointment == null)
			return Math.random();
		return cell.appointment.id;
	}
</script>


<tr>
	<td>{doctor.name}</td>
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
	td{
		border: 3px solid #cccccc;
	}
</style>