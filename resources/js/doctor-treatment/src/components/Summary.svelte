<table class="table table-bordered">
    <thead style="background-color: #2a7eeb; color: white; position: sticky; top:0;">
        <tr>
            <td>#</td>
            <td>Шүд</td>
            <td>Шинж тэмдэг</td>
            <td>Онош</td>
            <td>Эмчилгээ</td>
            <td>Төлсөн</td>
            <td>Өдөр</td>
        </tr>
    </thead>
    <tbody>
    	{#each $treatmentHistories as th, i}
            <tr>
            	<td>
            		<div>{i+1}</div>
            	</td>
                <td>
                    <div>{th.tooth_id}</div>
                </td>
                <td>
                	<!--
                	<textarea>
                        {th.symptom}
                    </textarea>-->
                   <!--  <Textfield textarea fullwidth bind:value={th.symptom}
                        input$aria-controls="helper-text-textarea" input$aria-describedby="helper-text-textarea"/> -->
                    <div>{th.symptom}</div>
                </td>
                <td>
                	<!--
                	<textarea>
                        {th.diagnosis}
                    </textarea> -->
                   <!--  <Textfield textarea fullwidth bind:value={th.diagnosis} input$aria-controls="helper-text-textarea" input$aria-describedby="helper-text-textarea" /> -->
                   <div>{th.diagnosis}</div>
                </td>
                <td>
                    <div>
                        {th.treatment.name}
                    </div>
                    <div>
                        {#if th.treatment.id == 1}
                            {#if th.tooth_type_id == 1}
                                <b>сүүн шүд</b><br>
                            {/if}
                            <b>цоорлын зэрэг - {th.decay_level}</b>
                        {/if}
                    </div>
                </td>
                <td>
                    {#if th.checkin_id == 0}
                        <div>Өөр эмнэлэгт хийлгэсэн эмчилгээ</div>
                    {:else}
                        <div>{th.price? th.price:0}₮</div>
                    {/if}
                </td>
                <td>
                    <div>{new moment(th.created_at).format('YYYY-MM-DD HH:mm:ss')}</div>
                </td>
            </tr>
        {/each}
    </tbody>
</table>

<script>

    import {treatmentHistories} from './stores/store.js';
    import Textfield from '@smui/textfield';
    import moment from 'moment';

    const setPointer = (id) => {
      var txtarea = document.getElementById(id);
      var start = txtarea.selectionStart;
      var end = txtarea.selectionEnd;
      var sel = txtarea.value.substring(start, end);
      txtarea.focus();
        txtarea.setSelectionRange(txtarea.value.length,txtarea.value.length);
    }

    const handleSymptomChange = (historyId, index) => {
        let el = document.getElementById(`symptom-${index}`);

        // may some validation
        el.selectionEnd= 0;
        $treatmentHistories[index].symptom = el.value;
    }

    const handleDiagnosisChange = (historyId, index) => {
        let el = document.getElementById(`diagnosis-${index}`);
        el.selectionEnd= 0;
        // may some validation

        $treatmentHistories[index].diagnosis = el.value;
    }

</script>