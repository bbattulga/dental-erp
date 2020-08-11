
<div id="allNotesModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" on:click={()=>show=false}>
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="overflow: auto;">
            <div class="modal-header">
                <h5 class="modal-title">Шинж тэмдэг, онош</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1rem 0;">
                <table class="table table-bordered">
                    <thead style="background-color: #2a7eeb; color: white; position: sticky; top:0;">
                        <tr>
                            <td>#</td>
                            <td>Шүд</td>
                            <td>Шинж тэмдэг</td>
                            <td>Онош</td>
                            <td>Эмчилгээ</td>
                            <td>Өдөр</td>
                        </tr>
                    </thead>
                    <tbody>
                    	{#each treatmentHistories as th, i}
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
                                    <div contenteditable="{true}"
                                    >
                                    	{th.symptom}
                                    </div>
                                </td>
                                <td>
                                	<!--
                                	<textarea>
                                        {th.diagnosis}
                                    </textarea> -->
                                    <div contenteditable="{true}">
                                    	{th.diagnosis}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {th.treatment.name}
                                    </div>
                                </td>
                                <td>
                                    <div>{th.created_at}</div>
                                </td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            </div>

            <slot name="footer">
            <!--
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        	</slot>
        </div>
    </div>
</div>


<script>

	export let show = false;
	export let treatmentHistories = [];

</script>