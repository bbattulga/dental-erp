<script type="text/javascript">
	
	import Cell from './Cell.svelte';
	import Modal from './modal/Modal.svelte';
	import UserForm from './form/UserForm.svelte';
	import axios from 'axios';


	// EXPECTS TIME FORMATS AS hh:mm

	export let appointment;
	export let times;

	let users = appointment.users;
	let currentUserDetail = null;
	let showModal = false;
	let doctor = appointment.doctor_shift.doctor;

	// it must be cells.length == times.length
	let cells = [];
	for (let i=0; i<times.length; i++){

		let time = times[i];

		// find user of time
		let user = null;

		let d = 1;
		for (let j=0; j<users.length; j++){

			if (users[j].start != time){
				continue;
			}

			// calculate user's time
			// expects hh:mm
			user = users[j];
			console.log(user.name+' match '+time);
			let sh = parseInt(user.start.slice(0, user.start.indexOf(':')));
			let eh = parseInt(user.end.slice(0, user.end.indexOf(':')));
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
		user.id = 0;
		user.shift_id = appointment.doctor_shift.id;
		detail.user = user;

		axios.post('/reception/time/add', detail)
			.then(response=>{
				console.log(response);
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