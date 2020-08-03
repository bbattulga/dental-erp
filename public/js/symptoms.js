
function dateFormat(d){

	let year = d.getFullYear();
	let month = d.getMonth() + 1;
	let day = d.getDate();
	let hours = d.getHours();
	let minutes = d.getMinutes();

	let format = `${year}-${month<10?'0'+month:month}-${day<10?'0'+day:day} ${hours}:${minutes}`
	return format;
}

function handleCreateSuccess(data){
	alert('Амжилттай хадгалагдлаа');
}

function handleCreateFail(err){
	alert('Алдаа гарлаа');
	console.log(err);
}

function saveSymptom(event, user_id, inputElem){
	event.preventDefault();
	event.stopPropagation();
	// save symptom
	let data = {
		user_id: user_id,
		description: inputElem.val(),
		date: dateFormat(new Date())
	}
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$.ajax({
		type: 'POST',
		url: '/api/symptoms/create',
		data: data,
		success: function(responsedata){handleCreateSuccess(data)},
		fail: handleCreateFail
	})
	$('#symptomModal').modal('hide');
}

function confirmSaveSymptom(event, user_id, inputElem){
	event.preventDefault();
	event.stopPropagation();
	if (inputElem.val().length == 0){
		return;
	}
	if (!confirm('Тэмдэглэл хадгалах?')){
		inputElem.val('');
		console.log(inputElem.val());
		return;
	}
	saveSymptom(event, user_id, inputElem);
}