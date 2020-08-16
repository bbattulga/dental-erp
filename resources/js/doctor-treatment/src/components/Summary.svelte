<table id="summary-table" class="table table-bordered">
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
                    <div>{th.tooth_id == 0? 'Бүх шүд': th.tooth_id}</div>
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
    import JQuery from 'jquery';
    import dt from 'datatables.net';
    import dtButtons from 'datatables.net-buttons';

    import colVis from 'datatables.net-buttons/js/buttons.colVis';
    import html5Btn from 'datatables.net-buttons/js/buttons.html5';
    import printBtn from 'datatables.net-buttons/js/buttons.print';

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

    // run script
    JQuery.noConflict();

    dt(window, JQuery);
    dtButtons(window, JQuery);
    colVis(window, JQuery);
    html5Btn(window, JQuery);
    printBtn(window, JQuery);

    JQuery(document).ready(()=>{
        let table = JQuery('#summary-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-secondary'
                },
                {
                    extend: 'print',
                    className: 'btn btn-secondary'
                },
                {
                  extend: 'pdf',
                  className: 'btn btn-secondary',
                  customize: function (doc) {
                    doc.content[1].table.widths = 
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                  }
                }, 
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.15/i18n/Mongolian.json'
            }
        });

        table.buttons().container()
                .appendTo('#summary-table_wrapper .col-md-6:eq(0)');
       //  table.buttons().container().addClass('btn-group');
        // JQuery('.dt-buttons').addClass('btn-group');
        // JQuery('.dt-button').addClass('btn-secondary');
    });

</script>