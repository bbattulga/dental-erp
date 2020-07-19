<script>
	import TimeTable from './components/TimeTable.svelte';
	import axios from 'axios';

	import TableFilter from './components/TableFilter.svelte';
	import Modal from './components/modal/Modal.svelte';

	import {fly} from 'svelte/transition';
	import {fade} from 'svelte/transition';

	import {storeShifts, storeDoctors, storeTimes} from './stores/stores.js';

	const unsubscribeDoctors = storeDoctors.subscribe((old)=>null);
	let LOADING = true;

	// /api/shift -shifts of day
	// /api/shifts - all shifts
	// /api/shift_interval - shift interval like 2020-07-01-2020-07-01
	// shift interval should specify staff with id. else things will get messy.

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
	for (let i=9; i<21; i++) {
		let prefix = (i<10)? '0': '';
		times.push(prefix+i+":00")
	};
	storeTimes.update(old=>times);

	const dateFormat = (date) =>{
		return `${date.getFullYear()}-${date.getMonth()}-${date.getDate()}`;
	}

	const handleSelectDate = (event) => {
		let detail = event.detail;
		let date = detail.date;
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
	class="main-container"
	class:background={fullscreen} on:click|self={()=>fullscreen=!fullscreen}>

	<div 
		class:hidden={!LOADING}
		class="loading-container">
		<img src="/js/apps/timetable/src/components/assets/loading-200-200-grey.gif" alt="loading">
	</div>

	<!--
	{#if fullscreen}
	<div class="btn-close-fullsreen" 
		on:hover={()=>console.log('onhover')}
		on:click={()=>fullscreen=!fullscreen}>
		<img src="/js/apps/timetable/src/components/assets/close-red-512.png" alt="close">
	</div>
	{/if}
	-->
	<!--
	{#if !fullscreen}
	<div class="btn-fullscreen" on:click={handleFullscreen}>
		<img src="/js/apps/timetable/src/components/assets/fullscreen-100218.png" alt="close">
	</div>
	{/if}
	-->
	<div
		class:fcenter={fullscreen}>
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

		box-shadow: 1px 1px 2px grey;
		padding: 10px;
	}

	.hidden{
		display: none;
	}

	.loading-container{
		width: 200px;
		height: 200px;
		position: absolute;
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
	.fcenter{
		position: fixed;
		width: 95vw;
		height: 95vh;
		background: white;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		margin: 10px auto;
		display: flex;
		overflow: auto;
	}

	.btn-fullscreen{
		z-index: 1000;	
		display: block; 
		width: 32px;
		height: 32px;
		margin: 10px;
		position:absolute; 
		top: 0; right: 0;

		cursor: pointer;
	}

	.btn-close-fullsreen{
		z-index:1000000;
		width: 32px;
		height: 32px;
		position: fixed;
		top: 10px;
		right: 10px;
		cursor: pointer;
	}

	.btn-close-fullsreen > img{
		max-width: 100%;
		height: auto;
	}

	.btn-fullscreen > img{
		max-width: 100%;
		height: auto;
	}

	.background{
		z-index: 100000;
		top: 0;
		left: 0;
		position: fixed;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5	);

		-webkit-animation: fadein 0.3s; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: fadein 0.3s; /* Firefox < 16 */
        -ms-animation: fadein 0.3s; /* Internet Explorer */
         -o-animation: fadein 0.3s; /* Opera < 12.1 */
            animation: fadein 0.3s;
	}

	.row{
		display: flex;
	}
</style>