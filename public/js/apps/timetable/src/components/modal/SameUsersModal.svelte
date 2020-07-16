<script type="text/javascript">
		
	import {createEventDispatcher} from 'svelte';
	export let users;

	const dispatch = createEventDispatcher();

	const handleChoose = (user) => {
		user.phone = user.phone_number;
		let detail = {user};
		dispatch('submit', detail);
	}
</script>

<div>
	<h3>Хэрэглэгч бүртгэлтэй байж магадгүй байна</h3>
	{#each users as user}
		<div class="row">
			<div class="user-info"><p>{user.name} - {user.phone_number}</p></div>
			<div class="btn-add" on:click={()=>handleChoose(user)}>Цаг захиалах</div>
		</div>
	{/each}
</div>

<style>
	.row{
		display: grid;
		grid-template-columns: 8fr 2fr;
		width: 100%;
		background-color: #e3e3e3e3;
		max-height: 50px;
	}

	.row *{
		font-size: 0.7em;
	}

	.user-info{
		float: left;
		display: flex;
		align-items: center;
	}


	.btn-add{
		float: left;
		font-family: 'Montserrat', Arial, Helvetica, sans-serif;
		border: #fbfbfb solid 4px;
		cursor:pointer;
		background-color: #3498db;
		color:white;
		-webkit-transition: all 0.3s;
		-moz-transition: all 0.3s;
		transition: all 0.3s;
	}
</style>