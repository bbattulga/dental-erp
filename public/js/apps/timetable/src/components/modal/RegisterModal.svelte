<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	import {fly} from 'svelte/transition';
	import Modal from './Modal.svelte';

	export let show = false;

	// 2way binded.
	// inital values can be set with props
	export let name = "";
	export let last_name ="";
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

	function handleDelete(){
		//console.log('form trying to del ', appointment);
		dispatch('delete', appointment);
	}
</script>

<Modal bind:showModal={show}>
<div id="form-main">
  <div id="form-div"
  	transition:fly="{{y: -200, duration: 500}}">
  	<div class="btn-close"
  		on:click|preventDefault|stopPropagation={close}>
  		<img src="/js/apps/timetable/src/components/assets/close.png">
  	</div>

    <form class="form" id="form1" on:click|stopPropagation|preventDefault>
      <h1>Шинэ үйлчлүүлэгч бүртгэх</h1>
      <p class="name">
      	<label>Овог</label>
        <input bind:value={last_name} type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="нэр" id="name" />
      </p>

      <p class="name">
      	<label>Нэр</label>
        <input bind:value={name} type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="нэр" id="name" />
      </p>
      
      <p class="email">
      	<label>Утас</label>
        <input bind:value={phone}  type="text" class="validate[required,custom[email]] feedback-input" placeholder="Утас" />
      </p>

      <p class="email">
      	<label>Цахим хаяг</label>
        <input bind:value={email}  type="text" class="validate[required,custom[email]] feedback-input" />
      </p>

      <p class="email">
      	<label>Регистрийн дугаар</label>
        <input bind:value={register} type="text" class="validate[required,custom[email]] feedback-input"/>
      </p>

      <p class="email">
      	<label>Төрсөн он сар</label>
        <input bind:value={birthDate} type="date" class="validate[required,custom[email]] feedback-input" />
      </p>

      <p class="email">
      	<label>Хүйс</label>
        <select bind:value={gender}>
        	<option value={1} selected="selected">Эр</option>
        	<option value={0}>Эм</option>
        </select>
      </p>

      <p class="email">
      	<label>Гэрийн хаяг</label>
        <input  type="text" class="validate[required,custom[email]] feedback-input"/>
      </p>

      <p class="email">
      	<label>Тайлбар</label>
        <input  type="text" class="validate[required,custom[email]] feedback-input"/>
      </p>
      
      <div class="submit">
        <input 
        	on:click|preventDefault|stopPropagation={handleSubmit}
        	type="submit" value="Бүртгэх&Эмчилгээнд оруулах" id="button-blue"/>
        <div class="ease"></div>
      </div>
    </form>
  </div>
</Modal>




<style type="text/css">

label{
	font-size: 1.2em;
	color: black;
}

.btn-close{
	width: 32px;
	height: 32px;
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

#feedback-page{
	text-align:center;
}

#form-main{
	width:100%;
	float:left;
	padding-top:0px;
	overflow: auto;
	max-height: 80%;
}

#form-div {
	background-color:white;
	padding-left:35px;
	padding-right:35px;
	padding-top:35px;
	padding-bottom:50px;
	width: 50%;
	left: 50%;
	max-height: 95%;
	overflow: auto;
	position: absolute;
	transform: translateX(-50%);
  -moz-border-radius: 7px;
  -webkit-border-radius: 7px;
}

.feedback-input {
	color:#3c3c3c;
	font-family: Helvetica, Arial, sans-serif;
  font-weight:500;
	font-size: 18px;
	border-radius: 0;
	line-height: 22px;
	background-color: #fbfbfb;
	padding: 13px 13px 13px 54px;
	margin-bottom: 10px;
	width:100%;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	box-sizing: border-box;
  border: 3px solid rgba(0,0,0,0);
}

.feedback-input:focus{
	background: #fff;
	box-shadow: 0;
	border: 3px solid #3498db;
	color: #3498db;
	outline: none;
  padding: 13px 13px 13px 54px;
}

.focused{
	color:#30aed6;
	border:#30aed6 solid 3px;
}

/* Icons ---------------------------------- */
#name{
	background-image: url(http://rexkirby.com/kirbyandson/images/name.svg);
	background-size: 30px 30px;
	background-position: 11px 8px;
	background-repeat: no-repeat;
}

#name:focus{
	background-image: url(http://rexkirby.com/kirbyandson/images/name.svg);
	background-size: 30px 30px;
	background-position: 8px 5px;
  background-position: 11px 8px;
	background-repeat: no-repeat;
}

input:hover, textarea:hover,
input:focus, textarea:focus {
	box-shadow: 1px 1px 2px black;
}

#button-blue{
	font-family: 'Montserrat', Arial, Helvetica, sans-serif;
	float:left;
	width: 100%;
	border: #fbfbfb solid 4px;
	cursor:pointer;
	background-color: #3498db;
	color:white;
	font-size:24px;
	padding-top:22px;
	padding-bottom:22px;
	-webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	transition: all 0.3s;
  margin-top:-4px;
  font-weight:700;
}

#button-blue:hover{

}
	
.submit:hover {

}
	
.ease {
	width: 0px;
	height: 74px;
	background-color: #fbfbfb;
	-webkit-transition: .3s ease;
	-moz-transition: .3s ease;
	-o-transition: .3s ease;
	-ms-transition: .3s ease;
	transition: .3s ease;
}

.submit:hover .ease{
  width:100%;
  background-color:white;
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