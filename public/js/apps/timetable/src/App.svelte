<script>
	import TimeTable from './components/TimeTable.svelte';
	import axios from 'axios';

	import TableFilter from './components/TableFilter.svelte';
	import Modal from './components/modal/Modal.svelte';

	import {fly} from 'svelte/transition';
	import {fade} from 'svelte/transition';

	import {floatToTime} from './lib/datetime.js';
	import {storeShifts, storeDoctors, storeTimes, currentRegister} from './stores/stores.js';

	const unsubscribeDoctors = storeDoctors.subscribe((old)=>null);
	let LOADING = true;

	// /api/shift -shifts of day
	// /api/shifts - all shifts
	// /api/shift_interval - shift interval like 2020-07-01-2020-07-01

	const unsubscribeShifts = storeShifts.subscribe(val=>[]);
	// intial data
	axios.get('/api/shifts/today')
		.then(response=>{
			console.log('shifts from server');
			console.log(response.data);
			storeShifts	.update(prev=>response.data);
			LOADING = false;
		}).catch(err=>{
			console.log(err);
		});

	axios.post('/api/doctors')
		.then(response=>{
			storeDoctors.update(old=>response.data);
			LOADING = false;
		})
		.catch(err=>{console.log(err);LOADING = false;});

	let times = [];
	const unsubscribeStoreTimes = storeTimes.subscribe((val)=>null);
	for (let i=9; i<21; i+=0.5) {
		times.push({
			float: i,
			str: floatToTime(i)
		});
	};
	storeTimes.update(old=>times);

	const dateFormat = (date) =>{
		return `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
	}

	let selectedDate = new Date().toLocaleDateString('en-CA');
	const handleSelectDate = (event) => {
		let detail = event.detail;
		let date = detail.date;
		selectedDate = date;
		let doctor = detail.doctor;

		console.log('request detail', detail);

		let promise = null;
		LOADING = true;
		if (date.length == 1){
			promise = axios.get(`/api/shifts/date/${date}`);
		}else if (date.length == 2){
			let doctorId = doctor == null? null:doctor.id;
			let data = {
				doctor_id: doctorId,
				date1: date[0],
				date2: date[1]
			}
			let url = '/api/shifts/date/datebetween';
			promise = axios.post(url, data);
		}

		promise.then(response=>{
					console.log('response to tablefilter');
					console.log(response);
					storeShifts	.update(prev=>response.data);
					LOADING = false;
				})
				.catch(err=>{
					console.log(err);
					LOADING = false;
				});
	}

	let fullscreen = false;

	const handleFullscreen = (event) => {
		fullscreen=!fullscreen;
		console.log('fullscreen');
	}
</script>
<div 
	class="main-container">
	<div 
		transition:fade
		class:hidden={!LOADING}
		class="loading-container">
		<img src="/img/gifs/loading-200-200-grey.gif" alt="loading">
	</div>
	<div>
		<TableFilter
			on:selectDate={handleSelectDate}/>
	</div>

</div>

<style>
	.main-container{
		width: 100%;
		background: white;
		position: relative;
		min-height: 100%;

		padding: 10px;
	}

	.hidden{
		display: none;
	}

	.loading-container{
		width: 200px;
		height: 200px;
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		z-index: 2000000000;
	}

	.loading-container > img{
		max-width: 100%;
		height: auto;
	}

	.main-div{
		background: white;
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;

		box-shadow: 1px 1px 2px grey;
		-webkit-animation: fadein 1s; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: fadein 1s; /* Firefox < 16 */
        -ms-animation: fadein 1s; /* Internet Explorer */
         -o-animation: fadein 1s; /* Opera < 12.1 */
            animation: fadein 1s;

	}

		@keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Firefox < 16 */
	@-moz-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Safari, Chrome and Opera > 12.1 */
	@-webkit-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Internet Explorer */
	@-ms-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}

	/* Opera < 12.1 */
	@-o-keyframes fadein {
		from { opacity: 0; }
		to   { opacity: 1; }
	}
</style>