<script>
	
	import axios from 'axios';
	import TreatmentForm from './components/TreatmentForm.svelte';

	let treatmentCategories = ['Emchilgee', 'Gajig zasal'];

	function handleSubmit(event){
		let treatment = event.detail.treatment;
		
	}

</script>

<main>
	<TreatmentForm
		on:submit={handleSubmit}
		treatmentCategories={treatmentCategories}/>

</main>

<style>
	main {
		text-align: center;
		padding: 1em;
		width: inherit;
		height: inherit;
		position: inherti;
		margin: 0 auto;
	}

	h1 {
		color: #ff3e00;
		text-transform: uppercase;
		font-size: 4em;
		font-weight: 100;
	}

	@media (min-width: 640px) {
		main {
			max-width: none;
		}
	}
</style>