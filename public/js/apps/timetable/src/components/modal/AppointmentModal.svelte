<script type="text/javascript">
	
	import {createEventDispatcher} from 'svelte';
	import {onDestroy} from 'svelte';
	import {fly} from 'svelte/transition';
	import Modal from './Modal.svelte';
	import axios from 'axios';
	import CheckInModal from './CheckInModal.svelte';
	import CheckInState from '../CheckInState.svelte';
	import {floatToTime, timeToFloat, isValidTime} from '../../lib/datetime.js';
	import {checkinStateName} from '../../lib/lib.js';
	import Textfield from '@smui/textfield';
	import HelperText from '@smui/textfield/helper-text/index';

	export let show = true;
	export let shift;
	export let doctor;
	export let appointment;
	export let time;

	let newUser = false;
	let validTimeStart = true;
	let validTimeEnd = true;


	// dispatch events
	const dispatch = createEventDispatcher();

	onDestroy(()=>appointment=null);

	let showAppointmentForm = true;
	let showRegisterForm = false;

	// assign default values
	let empty = appointment == null;
	let name = empty? '': appointment.name;
	let phone = empty? '': appointment.phone;
	let hours = 1;
	export let start = '09:00';
	export let end = '10:00';
	hours = empty? 1: timeToFloat(appointment.end)-timeToFloat(appointment.start);
 	start = start==null? time.str: appointment.start;
 	end = 0;
 	// re-eval end on user change hours
	end = floatToTime(time.float+hours);
	let preStart = start;
	let preEnd = end;
	let cancelCode = '';
	

	const close = () => {
		console.log('close');
		show = false;
		console.log(show);
		dispatch('close');
	}	

	const handleSubmit = () => {

		// validation
		if (name.length == 0 || (phone.length == 0))
			return;
		name = name.charAt(0).toUpperCase() + name.slice(1);
		if (!isValidTime(start)){
			validTimeStart = false;
			return;
		}
		validTimeStart = true;

		if (!isValidTime(end)){
			validTimeEnd = false;
			return
		}
		validTimeEnd = true;
		// validatio end

		// just visited or edited existing user cell
		if (appointment!= null){
			close();
			return;
		}
		store();
	}

	const store = (user=null) => {

		let _detail = {
			appointment:{
				shift_id: shift.id,
				user_id: user==null? 0:user.id,
				name: user==null? name: user.name,
				phone: user==null? phone: user.phone_number,
				hours,
				start,
				end
			}
		}
		dispatch('submit', _detail);
		close();
	}

	const handleDelete = () => {
		//console.log('form trying to del ', appointment);
		appointment.code = cancelCode;
		dispatch('delete', appointment);
	}

	const toggleForm = () => {
		showAppointmentForm = !showAppointmentForm;
		showRegisterForm = !showRegisterForm;
	}

	const handleRegister = () => {
		let currentData = {
			name,
			phone
		}
		dispatch('register', currentData);
	}

	const handleChangeTime = () => {
		let detail = {
			start,
			end
		}

		if (name.length == 0 || (phone.length == 0))
			return;

		if (!isValidTime(start)){
			validTimeStart = false;
			return;
		}
		validTimeStart = true;

		if (!isValidTime(end)){
			validTimeEnd = false;
			return
		}
		validTimeEnd = true;

		dispatch('changeTime', detail);
	}

	const handleTimeInput = () => {
		if (start.length < 5){
			validTimeStart = false;
		}else{
			validTimeStart = true;
		}

		if (end.length < 5){
			validTimeEnd = false;
		}else{
			validTimeEnd = true;
		}
	}

	const handleClickInputField = (event) => {

	}

	const handleChangeData = (event) => {
		if (appointment == null)
			return;
		if (phone.length != 8){
			return;
		}
		for (let i=0; i<phone.length; i++){
			if (!((phone.charAt(i) >='0') || (phone.charAt(i) <='9'))){
				alert('Утасны дугаар алдаатай байна')
				phone = appointment.phone;
				return;
			}
		}

		if (name.length < 3){
			alert('Нэрээ зөв оруулна уу');
			name = appointment.name;
		}
		for (let i=0; i<name.length; i++){
			if (name.charAt(i) == '.')
				continue;
			if (!(name.match("^[a-zA-Z\(\)]+$"))){
				alert("нэрээ зөв оруулна уу")
				return;
			}
		}
		let data = {
			id: appointment.id,
			name,
			phone
		}

		axios.put('/api/appointments/update', data)
			.then(response=>{
				appointment.name = name;
				appointment.phone = phone;
				appointment = appointment;
			})
			.catch(err=>{
				alert('Алдаа гарлаа')
			})
	}
</script>


<Modal 
	bind:showModal={show}>

<div transition:fly="{{y: -200, duration: 500}}" class="card mb-4 center" style="max-width: 500px;">
<div class="card-body">
	<div class="btn-close"
  		on:click|preventDefault|stopPropagation={close}>
  		<img src="/js/apps/timetable/src/components/assets/close.png">
  	</div>
                            <h5 class="mb-4">{appointment == null ? 'Цаг захиалах':'Захиалгын мэдээлэл'}</h5>
                           <!-- <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Нэр</span>
                                </div> 
                                <input bind:value={name}
                                on:change={handleChangeData}
                                type="text" class="form-control" placeholder="" aria-label="Username"
                                    aria-describedby="basic-addon1"> 
                            </div> -->

                           <div class="input-group mb-3" style="width: 100%;">
						        <Textfield on:change={handleChangeData}
						         variant="outlined" bind:value={name} label="Нэр" input$aria-controls="helper-text-outlined-a" input$aria-describedby="helper-text-outlined-a" 
						        style="width: 100%; max-height: 100%; color: yellow;"/>
						      </div>

						      <!--
                            <div class="input-group mb-3">
                               <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Утас</span>
                                </div>
                                <input bind:value={phone}
                                on:change={handleChangeData}
                                type="text" class="form-control" placeholder="" aria-label="Username"
                                    aria-describedby="basic-addon1">
                            </div> -->
                            <div class="input-group mb-3" style="width: 100%;">
						        <Textfield on:change={handleChangeData}
						         variant="outlined" bind:value={phone} label="Утас" input$aria-controls="helper-text-outlined-a" input$aria-describedby="helper-text-outlined-a" 
						        style="width: 100%; max-height: 100%;"/>
						      </div>


                            <div class="input-group mb-3">
                               <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Эмчийн нэр</span>
                                </div>
                                <input value={doctor.last_name.charAt(0)+'. '+doctor.name}
                                type="text" class="form-control"
                                    aria-describedby="basic-addon1" readonly>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Эмчилгээний цаг</span>
                                </div>
                                <input class:invalidinput={!validTimeStart} on:keyup={handleTimeInput} bind:value={start}
        								on:change={handleChangeTime}
                                	type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                

                                <input class:invalidinput={!validTimeEnd} on:keyup={handleTimeInput} bind:value={end}
        								on:change={handleChangeTime}
                                type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                            </div>

                            {#if appointment != null}
                            <div class="input-group mb-3">
                                <input bind:value={cancelCode}
                                	type="text" class="form-control" placeholder="цуцлах код" aria-label="цуцлах код"
                                    aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button on:click={handleDelete}
                                    	class="btn btn-outline-secondary" type="button">Цуцлах</button>
                                </div>
                            </div>
                           {/if}

                            {#if appointment == null}
						        <button on:click|preventDefault|stopPropagation={handleSubmit}
						        	class="btn btn-primary" style="float: right; margin: 8px;">Цаг захиалах</button>
						        {:else if appointment.user_id != 0}

						        <div on:click|preventDefault|stopPropagation
					        	class="btn" style="float: right; margin: 8px;">
					        		<!-- show state -->
					        		<CheckInState 
					        			iwidth={48}
					        			iheight={48}
					        			checkin={appointment.checkin}
					        		/>
					        		{checkinStateName(appointment.checkin.state)}
					        	</div>
					        	
						        {:else}
						       <button on:click|preventDefault|stopPropagation={handleRegister}
					        	class="btn btn-primary" style="float: right; margin: 8px;">Бүртгэх&Эмчилгээнд оруулах</button>
						        {/if}
                        </div>
	</div>
</Modal>




<style type="text/css">

fieldset{
	color :#e7523e;
}

.column{
	display: flex;
	flex-direction: column;
}

.invalidinput{
	border: 1px solid red;
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

.center{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
#form-div {
	background-color:white;
	padding-left:35px;
	padding-right:35px;
	padding-top:35px;
	padding-bottom:50px;
	width: 50%;
	top: 50%;
	left: 50%;
	max-height: 95%;
	overflow: auto;
	position: absolute;
	transform: translate(-50%, -50%);
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