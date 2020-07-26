<script type="text/javascript">
		
	import {createEventDispatcher} from 'svelte';
	import {fade} from 'svelte/transition';
	import Modal from './Modal.svelte';
	export let users = [];
	export let show = false;
	const dispatch = createEventDispatcher();

	const handleChoose = (user) => {
		user.phone = user.phone_number;
		let detail = {user};
		dispatch('submit', detail);
		show = false;
	}

	const handleCancel = (event) => {
		show = false;
		dispatch('cancel');
	}

	const handleBack = (event) => {
		users = [];
		show = false;
	}
</script>

<Modal 
	bind:showModal={show}>
<div class="form-div"
	on:click|stopPropagation|preventDefault
	transition:fade>
	<h3>Үйлчлүүлэгч бүртгэлтэй байж магадгүй байна<br />Төстэй хаягууд:</h3>
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

	<footer class="footer">
		<button class="btn-back btn btn-secondary" on:click|stopPropagation|preventDefault={handleBack}>Буцах</button>
		<button class="btn-cancel btn" on:click|stopPropagation|preventDefault={handleCancel}>Алгасах</button>
	</footer>
</div>
</Modal>

<style>


.form-div {
	background-color:white;
	padding-left:35px;
	padding-right:35px;
	padding-top:35px;
	padding-bottom:50px;
	width: 50%;
	top: 10%;
	left: 50%;
	max-height: 95%;
	overflow: auto;
	position: absolute;
	transform: translate(-50%);
  -moz-border-radius: 7px;
  -webkit-border-radius: 7px;
}

@media (max-width: 700px){
	.form-div{
		width: 80%;
	}
}

@media (max-width: 800px){
	.form-div{
		width: 80%;
	}
}

@media (max-width: 900px){
	.form-div{
		width: 80%;
	}
}

@media (max-width: 1000px){
	.form-div{
		width: 70%;
	}
}


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

	.btn-back{
		position: absolute;
		bottom: 0;
		left: 0;
		margin: 5px;
	}

	.btn-cancel{
		position: absolute;
		bottom: 0;
		right: 0;
		margin: 5px;
	}
</style>