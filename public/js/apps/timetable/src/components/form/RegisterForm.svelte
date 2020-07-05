<script type="text/javascript">
	

</script>

<div class="form">

	<div class="row">
		<header>
			Register form
		</header>
	</div>

	<div class="row">

		<div class="col-25">
			<label>Овог</label>
		</div>

		<div class="col-75">
			<input type="text">
		</div>
	</div>

	<div class="row">

		<div class="col-25">
			<label>Нэр</label>
		</div>

		<div class="col-75">
			<input type="text">
		</div>
	</div>

	<div class="row">

		<div class="col-25">
			<label>Регистрийн дугаар</label>
		</div>

		<div class="col-75">
			<input type="text">
		</div>
	</div>

	<footer>
		<button>register</button>
	</footer>

</div>


<style type="text/css">

	.form{
		display: flex;
		justify-content: center;
		flex-direction: column;
		width: 500px;
		position: fixed;
		top: 10px;
		left: 50%;
		transform: translateX(-50%);

		background-color: white;
		border-radius: 10px;
	}

	
	.row{
		max-width: 100%;
		background-color: #333333;
		margin: 30px;
	}

	.row:after{
		content: "";
		display: table;
		clear: both;
	}

	.col-25{
		width: 24%;
	}

	.col-75{
		width: 75%;
	}

	input[type=text]{
		max-width: 100%;
	}
</style>