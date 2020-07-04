<script>
	export let name;
	import TimeTable from './components/TimeTable.svelte';

	let data = {
		"appointments": [

		// appointment
			{

			"id": "1",

			"doctor_shift":{
				"doctor": {"name": "doctor1", "shift_type": "1|2|3"},
			},

			"shift": [9, 10, "...", 20],

			"users": [

				// user
				{
					"name": "patient 1",
					"phone": "8899xxxx",
					"start": "12:00",
					"end": "16:00",
					"registered": "0"
				},

				{
					"name": "another patient for doctor1",
					"phone": "8899xxxx",
					"start": "16:00",
					"end": "17:00",
					"registered": "0"
				}
				]
			},


			{

				"id": "2",

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
					"name": "patient 4",
					"phone": "8899xxxx",
					"start": "19:00",
					"end": "20:00",
					"registered": "1"
				},

				]
			} 

			]
		};

		let times = [];
		for (let i=9; i<21; i++) times.push(""+i+":00");

		let title = "table title";
		let showModal = false;
		function handleQueryCell(event){
			showModal = true;
		}

	</script>

	<main>
		<h1>{title}</h1>
		<TimeTable 
			on:queryCell={handleQueryCell}
			appointments={data.appointments}
			{times} />
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