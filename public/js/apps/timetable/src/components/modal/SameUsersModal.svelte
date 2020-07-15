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
			<p>{user.name} - {user.phone_number}</p>
			<button on:click={()=>handleChoose(user)} class="btn-add">Цаг захиалах</button>
		</div>
	{/each}
</div>

<style>
	.row{
		display: flex;
		flex-flow: row wrap;
		max-height: 100px;
		width: 100%;
	}

	.btn-add{
		display: inline-block;
	}
</style>