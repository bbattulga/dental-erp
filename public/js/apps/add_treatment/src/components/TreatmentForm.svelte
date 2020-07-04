<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	export let treatmentCategories;

	let dispatch = createEventDispatcher();

	let name = "";
	let category = 1;
	let type = 1;
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
			selection_type: type,
			price: price,
			limit: maxPrice,
		}

		dispatch('submit',treatment);
	}
</script>

<div class="form">

	<div class="field-wrap">
		<label>Эмчилгээний нэр:</label>
		<input bind:value={name}> <br />
	</div>

	<div class="field-wrap">
		<label>Төрөл:</label>
		<select bind:value={category}>
			{#each treatmentCategories as category, i (category.id)}
			{#if i==0}
			<option value={category.id} selected>{category.name}</option>
			{:else}
			<option value={category.id}>{category.name}</option>
			{/if}

			{/each}
		</select>
	</div>

	<div class="field-wrap">
		<label>Хийгдэх хэлбэр:</label>
		<select bind:value={type}>
			<option value={1}>Нэг шүд</option>
			<option value={2}>Бүх шүд</option>
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

		background-color: #333333;
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
		margin: 10px;
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