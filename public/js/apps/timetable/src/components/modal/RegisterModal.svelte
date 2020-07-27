<script type="text/javascript">
	
	import {createEventDispatcher, onDestroy} from 'svelte';
	import {fly} from 'svelte/transition';
	import Modal from './Modal.svelte';


	export let show = false;

	// 2way binded.
	// inital values can be set with props
	export let name = '';
	export let last_name ="";
	export let phone = '';
	export let gender = 0;
	export let email = "";
	export let register = "";
	export let address = "";
	export let info = "";
	export let birthDate = "";

	// dispatch events
	let dispatch = createEventDispatcher();

	const close = (event) => {
		console.log('close');
		show = false;
		dispatch('close');
	}

	const validRegister = (register) => {
		if (register.length != 10){
			return false;
		}

		if (register.charCodeAt(0) >= 'а' &&
			register.charCodeAt(1) <= 'я'){
			for (let i=2; i<register.length; i++){
				if (
					!(register.charAt(i) >= '0' &&
					register.charAt(i) <= '9')){
					return false;
				}
			}
		}
		return true;
	}

	const handleSubmit = (event) => {
		if (!validRegister(register)){
			alert('Регистрийн дугаараа зөв оруулна уу')
			return;
		}
		if (birthDate.length == 0){
			alert('Төрсөн он сараа оруулна уу');
			return;
		}
		if (last_name.length == 0 || (name.length == 0)){
			alert('Овог/Нэрээ оруулна уу');
			return;
		}
		let user = {
			name: name,
			last_name: last_name,
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

	const handleDelete = (event) => {
		//console.log('form trying to del ', appointment);
		dispatch('delete', appointment);
	}
</script>

<Modal bind:showModal={show}>
<div transition:fly="{{y: -200, duration: 500}}" class="card mb-4 center" style="max-width: 500px;"
	on:click|preventDefault|stopPropagation>
<div class="card-body">
<div class="btn-close"
  		on:click|preventDefault|stopPropagation={close}>
  		<img src="/js/apps/timetable/src/components/assets/close.png">
  	</div>
                            <h5 class="mb-4">Шинэ үйлчлүүлэгч бүртгэх</h5>

                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Овог</label>
                                        <input bind:value={last_name}
                                        	type="text" class="form-control" id="inputEmail4" placeholder="Овог">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Нэр</label>
                                        <input bind:value={name}
                                        type="text" class="form-control" id="inputPassword4" placeholder="Нэр">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Төрсөн он сар</label>
                                        <input bind:value={birthDate}
                                        	type="date" class="form-control date-inline" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Регистр</label>
                                        <input bind:value={register}
                                        type="text" class="form-control" id="inputPassword4" 
                                        placeholder="АБ9039...">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputState">Хүйс</label>
                                        <select bind:value={gender}
                                        	id="inputState" 
                                        	class="form-control">
                                            <option value={0} selected={true}>Эр</option>
                                            <option value={1}>Эм</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Утас</label>
                                        <input bind:value={phone}
                                        	type="text" class="form-control" id="inputEmail4" placeholder="">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Цахим хаяг</label>
                                        <input bind:value={email}
                                        	type="email" class="form-control" id="inputPassword4" 
                                        placeholder="...@gmail.com">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Гэрийн хаяг</label>
                                        <input bind:value={address}
                                        	type="text" class="form-control" id="inputEmail4" placeholder="">
                                        
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">тайлбар</label>
                                        <input bind:value={info}
                                        	type="text" class="form-control" id="inputPassword4" 
                                        
                                        placeholder="">
                                    </div>
                                </div>

                                <button on:click|preventDefault|stopPropagation={handleSubmit}
					        	class="btn btn-primary" style="float: right; margin: 8px;">Бүртгэх&Эмчилгээнд оруулах</button>
                            </form>

					        
						        
	</div>
</div>
</Modal>




<style>

.center{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
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

.treatment-hours{
	width: 10%;
}

@media (max-width: 700px){
	#form-div{
		width: 80%;
	}
}

@media (max-width: 800px){
	#form-div{
		width: 80%;
	}
}

@media (max-width: 900px){
	#form-div{
		width: 80%;
	}
}

@media (max-width: 1000px){
	#form-div{
		width: 70%;
	}
}


@media only screen and (max-width: 580px) {
	#form-div{
		left: 3%;
		margin-right: 3%;
		width: 88%;
		margin-left: 0;
		padding-left: 3%;
		padding-right: 3%;
	}
}

</style>