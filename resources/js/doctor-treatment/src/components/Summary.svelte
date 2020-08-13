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
                    <Textfield textarea fullwidth bind:value={th.symptom}
                        input$aria-controls="helper-text-textarea" input$aria-describedby="helper-text-textarea"/>
                </td>
                <td>
                	<!--
                	<textarea>
                        {th.diagnosis}
                    </textarea> -->
                    <Textfield textarea fullwidth bind:value={th.diagnosis} input$aria-controls="helper-text-textarea" input$aria-describedby="helper-text-textarea" />
                </td>
                <td>
                    <div>
                        {th.treatment.name}
                    </div>
                    <div>
                        {#if th.treatment.id == 1}
                            <b>{th.tooth_type_id == 1? 'сүүн шүд': ''}</b><br>
                            <b>цоорлын зэрэг - {th.decay_level}</b>
                        {/if}
                    </div>
                </td>
                <td>
                    <div>{th.price? th.price:0}₮</div>
                </td>
                <td>
                    <div>{th.created_at}</div>
                </td>
            </tr>
        {/each}
    </tbody>
</table>

<script>

    import {treatmentHistories} from './stores/store.js';
    import Textfield from '@smui/textfield';

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