<script type="text/javascript">
	import {createEventDispatcher} from 'svelte';

	const dispatch = createEventDispatcher();

	let searchVal = '';


	const handleTyping = (event) => {
		if (searchVal == ''){
			handleStopSearch(event);
			return;
		}
		let detail = {
			value: searchVal
		}
		dispatch('search', detail);
	}

	const handleStopSearch = (event) => {
		dispatch('stopsearch');
	}

</script>

<div class="search-container">
	<input bind:value={searchVal} 
			on:keyup={handleTyping}
			on:blur={handleStopSearch}
			class="search-input" type="text" placeholder="хайх">
</div>

<style>

.search-container{
	display: grid;
	grid-template-columns: 9fr 2fr;
	align-items: center;
	position: absolute; 
	bottom: 0; 
	right: 5%;
}

.search-input{
	width: 100%;
	height: 100%;
	border: none;
	background: #efefef;
	border-radius: 20px 0 0 20px;
}

.btn-search{
	border-radius: 0 20px 20px 0;
	background: #efefef;
}

.search-icon-wrapper{
	width: 100%;
	height: 100%;
	max-width: 40px;
	max-height: 40px;
	height: auto;
	cursor: pointer;
}

.search-icon-wrapper > img{
	min-width: 32px;
	border-radius: 0 20px 20px 0;
	max-width: 100%;
	height: auto;
}

</style>