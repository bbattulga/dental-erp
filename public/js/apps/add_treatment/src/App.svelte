<script>
	
	import axios from 'axios';
	import TreatmentForm from './components/TreatmentForm.svelte';

	let treatmentCategories = [];

	let categories = axios.post('/admin/treatment/categories')
		.then(response=>{
			treatmentCategories = response.data;
		});

	let lastRecordSuccess = false;
	window.addEventListener('click', function(event){
		event.preventDefault();
		lastRecordSuccess = false;
	});

	function handleSubmit(event){
		let treatment = event.detail;
		axios.post('/admin/treatment/store', treatment)
			.then(response=>{
				console.log(response);
				lastRecordSuccess = true;
			})
			.catch(err=>{
				alert('Алдаа гарлаа');
				console.log(err);
				lastRecordSuccess = false;
			});
	}

</script>

<main>
	<TreatmentForm
		on:submit={handleSubmit}
		treatmentCategories={treatmentCategories}/>

	{#if lastRecordSuccess}
		<div>Амжилттай хадгалагдлаа</div>
	{/if}
</main>

<style>
	main {
		text-align: center;
		padding: 1em;
		width: 100%;
		border-color: black;
		background-color: #333333;
	}

	h1 {
		color: #ff3e00;
		text-transform: uppercase;
		font-size: 4em;
		font-weight: 100;
	}
</style>