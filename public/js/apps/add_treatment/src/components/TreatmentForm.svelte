<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	export let treatmentCategories;

	let dispatch = createEventDispatcher();

	let name = "";
	let category = "";
	let type = "";
	let selections = [];
	let price = "";
	let maxPrice = "";

	function addSelection(){
		selections.push(1);
		console.log(selections.length);
		selections = selections;
	}

	function notifySubmit(){

		let treatment = {
			name: name,
			category: category,
			type: type,
			price: price,
			maxPrice: maxPrice,
		}

		dispatch('submit',treatment);
	}
</script>

<div class="form">

	<div class="field-wrap">
		<label>Нэр:</label>
		<input bind:value={name}> <br />
	</div>

	<div class="field-wrap">
		<label>Төрөл:</label>
		<select bind:value={category}>
			{#each treatmentCategories as category}
			<option>{category}</option>
			{/each}
		</select>
	</div>

	<div class="field-wrap">
		<label>Хийгдэх хэлбэр:</label>
		<select bind:value={type}>
			<option>нэг шүд</option>
			<option>Бүх шүд</option>
		</select>
	</div>

	<div class="field-wrap">
		<label>Үнэ:</label>
		<input bind:value={price} type="number">
	</div>

	<div class="field-wrap">
		<label>Үнийн хязгаар:</label>
		<input bind:value={maxPrice} type="number"><br />
	</div>

	<button class="btn-add" on:click={notifySubmit}>add</button>
</div>

<style type="text/css">
	
	.form{
		box-shadow: 2px 2px 3px black;
		height: auto;
		overflow: hidden;
		padding: 30px;
		border-radius: 10px;
	}

	input{
		width: 100%;
	}

	select{
		border-color: #e1e1e1e1;
		background-color: white;
	}

	.field-wrap{
		text-align: left;
	}

	.btn-add{
		margin: 10px auto;
		padding: 10px;
		width: 50%;
	}

	.btn-add:hover{
		box-shadow: 2px 2px 3px black;
	}
</style>