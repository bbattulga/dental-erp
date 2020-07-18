<script type="text/javascript">
		
	import {createEventDispatcher} from 'svelte';
	import {fade} from 'svelte/transition';
	export let users;

	const dispatch = createEventDispatcher();

	const handleChoose = (user) => {
		user.phone = user.phone_number;
		let detail = {user};
		dispatch('submit', detail);
	}

	const handleCancel = (event) => {
		dispatch('cancel');
	}
</script>

<div transition:fade>
	<h3>Үйлчлүүлэгч бүртгэлтэй байж магадгүй байна:</h3>
	<br />

	<div class="row header-row">

		<div class="row-item">
			#
		</div>

		<div class="row-item">
			Овог нэр
		</div>

		<div class="row-item">
			Утас
		</div>

		<div class="row-item">
			Регистр
		</div>
	</div>

	{#each users as user, i}
		<div class="row">

			<div class="row-item">
				{i+1}
			</div>

			<div class="row-item">
				{user.last_name[0]}. {user.name}
			</div>

			<div class="row-item">
				{user.phone_number}
			</div>

			<div class="row-item">
				{user.register}
			</div>
			<div class="btn-add" on:click={()=>handleChoose(user)}>Цаг захиалах</div>
		</div>
	{/each}

	<footer>
		<button on:click={handleCancel}>Буцах</button>
	</footer>
</div>

<style>

	*{
		box-sizing: border-box;
	}

	.header-row{
		font-size: 18px;
		padding: 8px;
		box-shadow: none;
	}

	.row{
		display: grid;
		justify-items: center;
		grid-template-columns: 1fr 3fr 3fr 3fr 3fr;
		grid-gap: 5px;
		overflow-x: auto;
		width: 100%;

		box-shadow: 1px 1px 1px grey;
	}

	.row-item{
		display: flex;
		justify-content: center;
		align-items: center;
	}


	.btn-add{
		float: right;
		font-family: 'Montserrat', Arial, Helvetica, sans-serif;
		border: #fbfbfb solid 4px;
		font-size: 14px;
		padding: 10px;
		cursor:pointer;
		background-color: #3498db;
		color:white;
		-webkit-transition: all 0.3s;
		-moz-transition: all 0.3s;
		transition: all 0.3s;
	}
</style>