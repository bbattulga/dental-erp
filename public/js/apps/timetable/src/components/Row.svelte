<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import axios from 'axios';


	// EXPECTS TIME FORMATS AS hh:mm

	export let shift_id;
	export let doctor;
	export let appointments;
	export let times;
	let users = appointments;

	// it must be cells.length == times.length
	let cellsData = [];
	for (let i=0; i<times.length; i++){

		let time = times[i];

		// find user of time
		let user = null;

		let d = 1;
		for (let j=0; j<users.length; j++){

			if (""+users[j].start+":00" != time){
				continue;
			}

			// calculate user's time
			// expects hh:mm
			user = users[j];
			console.log(user.name+' match '+time);
			let sh = user.start;
			let eh = user.end;
			d = eh - sh;

			// if d>1 then next available time will be i+1 or i+2 or i+timeGap
			i += d-1;
			// found a user
			break;
		}

		// put cell data that will be reported back
		let cellData = {
			user,
			doctor,
			time,
			hours: d,
			shift_id
		};
		cellsData.push(cellData);
	}

	const handleCellClick = (event)=>{
		console.log('row handle click');
	}

</script>


<tr>
	<td>{doctor.name}</td>
	{#each cellsData as cellData}
		<Cell 
			on:click={handleCellClick}
			data={cellData}/>
	{/each}
</tr>