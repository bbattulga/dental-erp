{#if treatmentHistory.checkin_id == 0}
	<div>Өөр эмнэлэгт хийлгэсэн эмчилгээ</div>

{:else if typeof treatmentHistory.id === 'number'}
<div>
	<div>{new moment(treatmentHistory.created_at).format('YYYY-MM-DD')} өдөр хийлгэсэн эмчилгээ</div>
	<!-- <div>{treatmentHistory.price}₮</div> -->
</div>
{/if}




<script>

	import moment from 'moment';
	export let treatmentHistory;

</script>