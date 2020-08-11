


<div class="col-md-3">
    <div class="card">
        <ul class="nav nav-tabs nav-justified ml-0 mb-2" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
                    aria-controls="first" aria-selected="true">Түүх</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="second-tab" data-toggle="tab" href="#second" role="tab"
                    aria-controls="second" aria-selected="false">Эмчилгээ</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane show active scroll" id="first" role="tabpanel" aria-labelledby="first-tab">

                <TreatmentHistoryList />
                
            </div>

            <div class="tab-pane scroll" id="second" role="tabpane2" aria-labelledby="second-tab">
                <div id="treatmentsContainer" class="card-body">
                    <Treatments />
                </div>
            </div>
        </div>
    </div>
    <form  method="post" id="treatmentsFinish">
        <br>
        <select class="form-control" name="nurse_id">
            <option value="0">Сувилагч сонгох</option>

        </select>
        <br>
        <input type="hidden" name="checkin_id">
        <button type="button" class="btn btn-primary btn-block">ДУУСГАХ</button>
    </form>
</div>

<Dialog bind:this={dialogElem} aria-labelledby="simple-title" aria-describedby="simple-content">
    <Title>{dialogTitle}</Title>
    <Content>{dialogContent}</Content>
    <Actions>
        <Button><Label>cancel</Label></Button>
        <Button><Label>OK</Label></Button>
    </Actions>
</Dialog>

<script>
    import List, {Item, Text} from '@smui/list';
    import Dialog, {Title, Content, Actions} from '@smui/dialog';
    import Button, {Label} from '@smui/button';
    import TreatmentHistoryList from './TreatmentHistoryList.svelte';
    import Treatments from './Treatments.svelte';

    let dialogElem;
    let dialogTitle = 'Dialog Title';
    let dialogContent = 'content';
    let showDialog = false;
</script>

<style>

    .treatment-text{
        color: #666666;
    }
</style>