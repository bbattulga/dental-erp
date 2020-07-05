<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import Modal from './modal/Modal.svelte';
	import UserForm from './form/UserForm.svelte';
	import axios from 'axios';


	// EXPECTS TIME FORMATS AS hh:mm

	export let doctor;
	export let appointments;
	export let times;
	let users = appointments;
	let currentUserDetail = null;
	let showModal = false;

	// it must be cells.length == times.length
	let cells = [];
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
		let cell = {
			user,
			doctor,
			time,
			hours: d
		};
		cells.push(cell);
	}
	console.log('cells', cells);
	const handleCellClick = (event)=>{
		let detail = event.detail;
		currentUserDetail = detail;	
		console.log('row handle click');
		showModal = true;
	}

	const handleSubmit = (event)=>{
		let detail = event.detail;
		console.log('trying to add user to appointments');
		let user = detail.user;
		user.user_id = 0;
		user.shift_id = appointments[0].shift_id;
		user.time = user.start;
		detail.user = user;
		console.log('sent like ');
		console.log(detail.user);
		axios.post('/reception/time/add', detail.user)
			.then(response=>{
				console.log('response data');
				console.log(response.data);
				let id = parseInt(response.data);
				let cell = {
					user,
					doctor,
					time: user.time,
					hours: user.hours,
				};
				cells = [...cells, cell];
			})
			.catch(err=>{
				console.log(err);
			});

	}
</script>


<tr>
	<td>{doctor.name}</td>
	{#each cells as cell}
		<Cell 
			on:click={handleCellClick}
			time={cell.time}
			user={cell.user} 
			doctor={cell.doctor}
			colspan={cell.hours}/>
	{/each}

	<Modal
		bind:showModal={showModal}>

		<UserForm 
			bind:show={showModal}
			on:submit={handleSubmit}
			detail={currentUserDetail} />

	</Modal>
</tr>