<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	import {fly} from 'svelte/transition';
	import Modal from './Modal.svelte';

	export let show = false;

	// 2way binded.
	// inital values can be set with props
	export let fname = "";
	export let lname ="";
	export let phone = "";
	export let gender = 1;
	export let email = "";
	export let register = "";
	export let address = "";
	export let info = "";
	export let birthDate = "";

	// dispatch events
	let dispatch = createEventDispatcher();

	function close(){
		console.log('close');
		show = false;
	}

	const handleSubmit = (event) => {

		let user = {
			name: fname,
			last_name: lname,
			register,
			phone_number: phone,
			email,
			birth_date: birthDate,
			sex: gender,
			location: address,
			info
		};

		let detail = {user};
		dispatch('submit', detail);

		close();
	}

	function handleDelete(){
		//console.log('form trying to del ', appointment);
		dispatch('delete', appointment);
	}
</script>

<Modal bind:showModal={show}>

	<div class="form" on:click|stopPropagation
		transition:fly="{ {y:-200, duration: 500} }">
		<header>
		<h1>Шинэ үйлчлүүлэгч бүртгэх</h1>
		<hr>
	</header>

	<div class="main">

		<div class="row-input">
			<label>Овог:</label>
			<input bind:value={fname}>
		</div>

		<div class="row-input">
			<label>Нэр:</label>
			<input bind:value={lname}>
		</div>

		<div class="row-input">
			<label>Хүйс:</label>
			<select bind:value={gender}>
				<option>male</option>
				<option>femanle</option>
			</select>
		</div>

		<div class="row-input">
			<label>Төрсөн он сар</label>
			<input type="date" bind:value={birthDate}>
		</div>

		<div class="row-input">
			<label>Регистр</label>
			<input bind:value={register}>
		</div>

		<div class="row-input">
			<label>email:</label>
			<input bind:value={email}>
		</div>

		<div class="row-input">
			<label>Утасны дугаар:</label>
			<input bind:value={phone}>
		</div>

		<div class="row-input">
			<label>Гэрийн хаяг:</label>
			<input bind:value={address}>
		</div>

		<div class="row-input">
			<label>тайлбар:</label>
			<input bind:value={info}>
		</div>

		<button class="btn btn-add" on:click={handleSubmit}>Бүртгэх</button>

	</div>


	<div 
		class="btn-cancel"
		on:click|preventDefault|stopPropagation={close}>
			<img src="/js/apps/timetable/src/components/assets/close.png">
	</div>
	<footer>
		
		
	</footer>
	</div> <!-- form end -->
</Modal>



<style type="text/css">
	
	input{
		background: white;
		width: 100%;
		border: 1px solid grey;

		padding: 10px;
		border-radius: 3px;
	}

	header{
		position: sticky;
		top: 0;
		margin-top: 0;
		background-color: white;
	}

	footer{
		position: relative;
		display: flex;
		flex-direction: row-reverse;
		align-items: center;
		width: 100%;
	}

	
	*{
		box-sizing: border-box;
		font-weight: 10;
		font-family: Arial Helvetica sans-serif;
	}

	.form{
		position: relative;
		display: flex;
		flex-direction: column;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);

		width: 60%;
		min-height: 50%;
		max-height: 100%;
		overflow: auto;
		border-radius: 10px;
		padding: 20px;
		background-color: white;
	}

	.title-sub{
		text-align: left;
		margin: 30px;
	}

	.row-input{
		display: grid;
		grid-template-columns: 3fr 7fr;
		text-align: left;
		max-width: 100%;
		margin: 30px;
	}

	@media (max-width: 800px){
		.row-input{
			display: block;
		}

		.form{
			min-width: 80%;
			min-height: 70%;
			max-height: 80%;
			overflow: auto;
		}
	}

	@media (max-width: 600px){
		.form{
			min-width: 80%;
			min-height: 70%;
			max-height: 80%;
			overflow: auto;
		}
	}
	.btn-add{
		margin: 10px;
		padding: 10px 20px;
		width: 40%;
		float: right;
		background-color: #0c374d;
		color: white;
	}

	.btn-add:hover{
		background-color: #093145;
	}

	.btn-cancel{
		position: absolute;
		top: 0;
		right: 0;
		width: 32px;
		height: 32px;
		margin: 10px;
	}

	.btn-cancel img{
		max-width: 100%;
		height: auto;
		cursor: pointer;
	}

	.container-cancel{
		position: absolute;
		left: 0;
		display: grid;
		grid-template-columns: 7fr 3fr;
		grid-gap: 5px;
		background: white;
		width: 50%;
	}

	.input-cancel{

	}
</style>