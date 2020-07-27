<script type="text/javascript">
	import {createEventDispatcher} from 'svelte';

	const dispatch = createEventDispatcher();

	let searchVal = '';


	const handleTyping = (event) => {
		if (searchVal.length == 0){
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
			class="search-input" type="text" placeholder="хайх">
</div>

<style>

.search-container{
	display: grid;
	grid-template-columns: 9fr 2fr;
	align-items: center;
}

.search-input{
	width: 100%;
	height: 100%;
	border: none;
	padding: 10px;
	background: #efefef;
	border-radius: 10px;

	float: right;
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