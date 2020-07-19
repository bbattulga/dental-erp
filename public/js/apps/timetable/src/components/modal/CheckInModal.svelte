<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	import {onDestroy} from 'svelte';
	import {fly} from 'svelte/transition';
	import Modal from './Modal.svelte';
	import axios from 'axios';

	export let show = true;
	export let shift;
	export let time;
	
	export let appointment;

	onDestroy(()=>appointment=null);

	let showAppointmentForm = true;
	let showRegisterForm = false;
	// dispatch events
	let dispatch = createEventDispatcher();

	// assign default values
	let name = null;
	let last_name = null;
	let phone =  null;
	let register = null;
	let hours =  1;
	let start = null;
	let end = null;
	let cancelCode = null;

	$:{
		name = appointment.name;
		last_name = appointment.user==null? '': appointment.user.last_name;
		phone =   appointment.phone;
		register = appointment.user==null? '': appointment.user.register;
		hours =  appointment.end-appointment.start;
		start =  parseInt(time.slice(0, time.indexOf(':')));
		hours = hours < 1? 1: hours;
		cancelCode = '';
	}

	$:end = start+hours;

	function close(){
		console.log('close');
		show = false;
		console.log(show);
	}	

	function handleSubmit(){
		console.log('handle submit checkin');
		let appointment = {
			shift_id: shift.id,
			name,
			last_name,
			phone,
			start,
			end
		}

		let detail = {appointment};
		dispatch('submit', detail);
	}


</script>


<Modal 
	bind:showModal={show}>

<div id="form-main">
  <div id="form-div"
  		transition:fly="{{y: -200, duration: 500}}">
  	<div class="btn-close"
  		on:click|preventDefault|stopPropagation={close}>
  		<img src="/js/apps/timetable/src/components/assets/close.png">
  	</div>

    <form class="form" id="form1">
      
      <h1 style="color: #444444;">Цаг захиалах</h1>
      <p class="name">
      	<label>Үйлчлүүлэгчийн нэр</label>
        <input bind:value={name} type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="нэр" id="name" 
        readonly="{appointment!=null}" />
      </p>
      
      <p class="name">
      	<label>Овог</label>
        <input bind:value={last_name} type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="нэр" id="name" 
        readonly="{appointment!=null}" />
      </p>

      <p class="name">
      	<label>Регистр</label>
        <input bind:value={register} type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="нэр" id="name" 
        readonly="{appointment!=null}" />
      </p>

      <p class="email">
      	<label>Утас</label>
        <input bind:value={phone} type="text" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Утас" 
        readonly="{appointment!=null}"/>
      </p>
      <p class="email">
      	<label>Эмчийн нэр:   </label>
        <label>{shift.doctor.name}</label>
      </p>

      <p class="email">
      	<label>Эмчилгээний цаг:   </label>
        <label>{start}:00-{end}:00</label>
      </p>

      <p class="email">
      	<label>Эмчилгээний хугацаа(цагаар)</label>
        <input name="treatment-hours" type="number" class="validate[required,custom[email]] feedback-input" bind:value={hours}/>
      </p>
      
      <div class="submit">
        <input on:click|preventDefault|stopPropagation={handleSubmit}
        	type="submit" value="Баталгаажуулах" id="button-blue"/>
        <div class="ease"></div>
      </div>
    </form>
  </div>
</Modal>




<style type="text/css">

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

label{
	font-size: 1.2em;
	color: #363636;
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

@media only screen and (max-width: 600px) {
	#form-div{
		width: 88%;
	}
}

</style>