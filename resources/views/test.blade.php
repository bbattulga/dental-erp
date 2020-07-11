<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<link rel="stylesheet" 
	href="{{asset('js/apps/timetable/public/build/bundle.css')}}">

	<style>
		*{
			box-sizing: border-box;
			font-weight: 10;
			font-family: Arial Helvetica sans-serif;
		}

		.form{
			width: 500px;
			margin: 10px auto;
			display: flex;
			flex-direction: column;
			background-color: white;

			padding: 10px;
			border-radius: 10px;
			box-shadow: 1px 2px 3px grey;
		}

		.col-2{
			width: 100%;

			display: grid;
			grid-template-columns: 5fr 5fr;
			grid-gap: 10px;
		}

		.m10{
			margin: 10px;
		}

		.col1{
			margin: 1px;
			padding: 3px;
		}

		.rows{
			display: flex;
			flex-direction: column;
			text-align: left;
			max-width: 100%;
		}

		.btn-add{
			width: 50%;
			margin: 10px auto;
		}

		.row{
			margin: 10px;
		}
	</style>
</head>
<body>

	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

	<div id="result"></div>

	<script type="text/javascript">

		let date1 = '2020-07-01';
		let date2 = '2020-07-10';
		let url = `/api/reception/time`
		axios.get(url)
			.then(response => {
				console.log('response');
				console.log(response);
				document.getElementById('result').innerText = response.data;
			})
			.catch(err => {
				console.log(err);
			})
	</script>
</body>
</html>