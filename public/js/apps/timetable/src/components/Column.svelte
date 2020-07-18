<script type="text/javascript">

	import Cell from './Cell.svelte';
	import Grid from 'svelte-grid';
	import gridHelp from 'svelte-grid/build/helper/index.mjs';


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
		if (cell==null || (cell.appointment == null))
			return Math.random();
		return `${cell.appointment.id}-${cell.appointment.start}`;
	}

	let gridItems = [gridHelp.item({id: generateId(null), x:0, y:0, w: 1, h: 3}),
					gridHelp.item({id: generateId(null), x:1, y:0, w: 1, h: 3})];

</script>

<div class="day monday">
	<div class="day_title">Monday</div>
	<div class="class red" data-tooltip="English Literature">2ELI1 [C1]</div>
	<div class="class b15 blue" data-tooltip="Probability and Statistics">2MPS1 [K2]</div>
	<div class="class b15 grey" data-tooltip="German">2GER1 [C1]</div>
	<div class="class short blue" data-tooltip="Additional Probability and Statistics">2MPS+ [K2]</div>
</div>

<style>


	.day {
	  width: 18%;
	  height: 100vh;
	  float: left;
	  background-color: #fff;
	  background-image: linear-gradient(rgba(0,0,0,.08) 50%, transparent 50%);
	  background-size: 1px 20%;
	}

	.day_title {
	  height: 10%;
	  background-color: #34495e;
	  font-size: 12px;
	  font-weight: 600;
	  text-transform: uppercase;
	  text-align: center;
	  line-height: 10vh;
	}


	.class {
	  width: 100%;
	  height: 15vh; /*90min*/
	  background-color: magenta;
	  font-size: 2vw;
	  font-weight: 300;
	}

	.class.short { height: 7.5vh; line-height: 7.5vh; } /* 45min class */
	.class.b15 { /* margin-top: 2.5vh;  */} /* after 15 min break */
	.class.b45 { /* margin-top: 7.5vh;  */} /* after 45 min break */
	.class.b90 { /* margin-top: 15vh;  */} /* after 2x45 min break */
	.class.b135 { /* margin-top: 22.5vh ;*/ } /* after 3x45 min break */

	.green { background-color: #2ecc71; }
	.turquoise { background-color: #1abc9c; }
	.navy { background-color: #34495e; }
	.blue { background-color: #3498db; }
	.purple { background-color: #9b59b6; }
	.grey { background-color: #bdc3c7; color: #202020; }
	.gray { background-color: #7f8c8d; }
	.red { background-color: #e74c3c; }
	.orange { background-color: #f39c12; }
	.yellow { background-color: #f1c40f; color: #303030; }


</style>