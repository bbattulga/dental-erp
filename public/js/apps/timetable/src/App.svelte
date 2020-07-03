<script>
	export let name;
	import TimeTable from './components/TimeTable.svelte';
	import Dialog from './components/Dialog.svelte';

	let data = {
		"appointments": [

		// appointment
		{

			"id": "x",

			"doctor_shift":{
				"doctor": {"name": "doctor1", "shift_type": "1|2|3"},
			},

			"shift": [9, 10, "...", 20],

			"users": [

				// user
				{
					"name": "patient 1",
					"phone": "8899xxxx",
					"start": "14:00",
					"end": "17:00",
					"registered": "1|0"
				}
				]
			},


			{

				"id": "x",

				"doctor_shift":{
					"doctor": {"name": "doctor2", "shift_type": "1|2|3"},
				},

				"shift": [9, 10, "...", 20],

				"users":[
				// user
				{
					"name": "patient 2",
					"phone": "8899xxxx",
					"start": "16:00",
					"end": "17:00",
					"registered": "0"
				},

				{
					"name": "patient 3",
					"phone": "8899xxxx",
					"start": "17:00",
					"end": "17:00",
					"registered": "0"
				},
				{
					"name": "patient 3",
					"phone": "8899xxxx",
					"start": "17:00",
					"end": "17:00",
					"registered": "0"
				},

				{
					"name": "patient 4",
					"phone": "8899xxxx",
					"start": "19:00",
					"end": "17:00",
					"registered": "1"
				},

				{
					"name": "patient 5",
					"phone": "8899xxxx",
					"start": "9:00",
					"end": "17:00",
					"registered": "1"
				}

				]
			} 

			]
		};

		let title = "table title";

		let currentUser = null;
		let dialogActive = false;
		function handleQueryCell(event){
			dialogActive = true;
			currentUser = event.detail.user;
			console.log(currentUser);
		}

	</script>

	<main>
		<h1>{title}</h1>
		<TimeTable 
			on:queryCell={handleQueryCell}
			appointments={data.appointments} />

		<Dialog 
			user={currentUser}
			bind:active={dialogActive} />

	</main>

	<style>
		main {
			position: inherit;
			height: inherit;
			overflow: auto;
			text-align: center;
			padding: 20px;
			max-width: 240px;
			margin: 0 auto;
		}

		h1 {
			color: #ff3e00;
			text-transform: uppercase;
			font-size: 1.2em;
			font-weight: 100;
		}

		@media (min-width: 640px) {
			main {
				max-width: none;
			}
		}
	</style>