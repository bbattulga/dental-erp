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
		<div class="row">
			<div class="col-sm-6">
				<div class="input-group">
					<input type="text" class="form-control typeahead" name="query" id="query"
					placeholder="Хайх..." data-provide="typeahead"
					autocomplete="off"
					bind:value={searchVal} 
					on:keyup={handleTyping}>
					<div class="input-group-append ">
						<button type="submit" class="btn btn-primary default p-1 pl-3 pr-3 pt-2">
							<i class="simple-icon-magnifier"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
</div>

<style>

.search-container{
	align-items: center;
	min-width: 100%;
	max-width: 100%;
}

.row{
	display: flex;
	justify-content: flex-end;
}

</style>