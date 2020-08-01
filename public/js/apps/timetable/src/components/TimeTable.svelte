<script type="text/javascript">

	import Cell from './Cell.svelte';
	import Column from './Column.svelte';
  import {cellHeightUnit} from '../stores/sizes.js';
  import {onMount, onDestroy} from 'svelte';


	// contains {doctor, appointments}
	export let shifts = [];
	export let times = [];

  const unsubscribeHeightUnit = cellHeightUnit.subscribe((val)=>val);
  onMount(()=>{

  });

  onDestroy(()=>{
    unsubscribeHeightUnit();
  })
</script>


<div class="container">

	<div class="day time">
		<div class="corner-title height">Цаг/Эмч</div>
    {#each times as time, i}
        {#if time.float-Math.floor(time.float) == 0}
        <div class="hour  ">{time.str}</div>
        {/if}
    {/each}
	</div>

  {#if shifts.length == 0}
    <div style="margin: 10px auto; color: black;">ээлж байхгүй байна</div>
  {/if}
	{#each shifts as shift, i (shift.id)}
		<Column 
      colWidth={`${100/shifts.length}%`}
      on:addAppointment={(event)=>{shift.appointments.push(event.detail.appointment); shifts=shifts}}
      on:refresh={()=>{shifts=shifts;}}
      {shift}
      {times}/>
	{/each}
</div>

<style>

.container{
  position: relative;
	width: 100%;
	min-height: 100%;
  display: flex;
  padding: 0;
  color: #efefef;
  padding: 7px;
}

*{
  box-sizing: border-box;
}

.cell{

}

.hour {
  height: 8vh;
  line-height: 8vh;

  word-wrap: break-word;
  background-color: #194b8d;
  color: white;
  font-size: 1.5vh;
  text-align: center;
  border: 1px solid #e0e0e0e0;
  border-radius: 5px;
  width: 5vw;
}

.corner-title {
  background-color: #0c2546;
  color: white;
  margin-right: 1px;
  margin-right: 1px;
  font-size: 1.5vh;
    font-weight: 600;
    text-transform: uppercase;
    text-align: center;
    line-height: 8vh;
    word-wrap: wrap;
}


.day.time { width: 5vw;}

.day_title {
   /*z-index: 1030;
   position: sticky;
   top: 0;*/
  border-right: 1px solid white;
  height: 10%;
  background-color: #1E2749;
  font-size: 12px;
  font-weight: 600;
  text-transform: uppercase;
  text-align: center;
  line-height: 10vh;
}

.class {
  width: 100%;
  height: 15vh; /*90min*/
  background-color: magenta;
  font-size: 2vw;
  font-weight: 300;
}

.class.short { height: 7.5vh; line-height: 7.5vh; } /* 45min class */
.class.b15 { /* margin-top: 2.5vh;  */} /* after 15 min break */
.class.b45 { /* margin-top: 7.5vh;  */} /* after 45 min break */
.class.b90 { /* margin-top: 15vh;  */} /* after 2x45 min break */
.class.b135 { /* margin-top: 22.5vh ;*/ } /* after 3x45 min break */

.green { background-color: #2ecc71; }
.turquoise { background-color: #1abc9c; }
.navy { background-color: #34495e; }
.blue { background-color: #3498db; }
.purple { background-color: #9b59b6; }
.grey { background-color: #bdc3c7; color: #202020; }
.gray { background-color: #7f8c8d; }
.red { background-color: #e74c3c; }
.orange { background-color: #f39c12; }
.yellow { background-color: #f1c40f; color: #303030; }

.spacing { background-color: transparent; }



/* Add this attribute to the element that needs a tooltip */
[data-tooltip] {
  position: relative;
  z-index: 2;
  cursor: pointer;
  width: initial;
}

/* Hide the tooltip content by default */
[data-tooltip]:before,
[data-tooltip]:after {
  visibility: hidden;
  pointer-events: none;
}

/* Position tooltip above the element */
[data-tooltip]:before {
  position: absolute;
  bottom: 110%;
  left: 50%;
  margin-bottom: 10px;
  margin-left: -75px;
  padding: 7px 5px;
  width: 140px;
  background-color: black;
  color: #fff;
  content: attr(data-tooltip);
  text-align: center;
  font-size: 14px;
  line-height: 1.2;
}

/* Triangle hack to make tooltip look like a speech bubble */
[data-tooltip]:after {
  position: absolute;
  bottom: 110%;
  left: 50%;
  margin-left: -7px;
  margin-bottom: 3px;
  width: 0;
  border-top: 7px solid black;
  border-right: 7px solid transparent;
  border-left: 7px solid transparent;
  content: " ";
  font-size: 0;
  line-height: 0;
}

/* Show tooltip content on hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  bottom: 90%;
}

</style>