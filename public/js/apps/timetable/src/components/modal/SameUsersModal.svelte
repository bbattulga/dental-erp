<script type="text/javascript">
		
	import {createEventDispatcher} from 'svelte';
	import {fade} from 'svelte/transition';
	import Modal from './Modal.svelte';
	
 	import DataTable, {Head, Body, Row, Cell} from '@smui/data-table';
	import Button, {Label} from '@smui/list';
	import Card from '@smui/card';


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
	<div class="btn-close"
  		on:click|preventDefault|stopPropagation={handleBack}>
  		<img src="/js/apps/timetable/src/components/assets/close.png">
  	</div>

	<h3>Төстэй хаягууд:</h3>
	<DataTable table$aria-label="People list" style="width: 100%;">
      <Head>
        <Row>
          <Cell><b>#</b></Cell>
          <Cell><b>Овог</b></Cell>
          <Cell><b>Нэр</b></Cell>
          <Cell><b>Регистр</b></Cell>
        </Row>
      </Head>
      <Body>

      	{#each users as user, i}
        <Row on:click={()=>handleChoose(user)}>
          <Cell>{i+1}</Cell>
          <Cell>{user.last_name}</Cell>
          <Cell>{user.name}</Cell>
          <Cell>{user.register}</Cell>
        </Row>
        {/each}
      </Body>
    </DataTable>
	<button class="btn-cancel btn btn-secondary" on:click|stopPropagation|preventDefault={handleCancel}>Алгасах</button>
	
</div>
</Modal>

<style>

.hovertb{
	
}
div:hover .hovertb{
	color: black;
}
.form-div {
	background-color:white;
	padding-left:35px;
	padding-right:35px;
	padding-top:35px;
	padding-bottom:50px;
	max-width: 50%;
	min-width: 450px;
	min-height: 400px;
	max-height: 600px;
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

.btn-close{
	width: 16px;
	height: 16px;
	position: absolute;
	top: 0;
	right: 0;
	margin: 3%;
	cursor: pointer;
}
.btn-close > img{
	max-width: 100%;
	height: auto;
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

	.btn-cancel{
		position: absolute;
		bottom: 0;
		right: 0;
		margin: 5px;
	}
</style>