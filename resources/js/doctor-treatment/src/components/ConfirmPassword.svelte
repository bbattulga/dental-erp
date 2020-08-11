<Dialog bind:this={confirmDialog} aria-labelledby="event-title"                 aria-describedby="event-content" 
    on:MDCDialog:closed={()=>console.log('close')}
    style="z-index: 1050;">
  <Title id="event-title">Эмчилгээ өмнө нь хийгдсэн байна</Title>
  <Content id="event-content">
    Шүд #{$selectedTooth} - {$selectedTreatment.name}
  </Content>
  <Actions>
    <Button action="none">
      <Label>Эмчилгээ устгах</Label>
    </Button>
    <Button action="all" default>
      <Label>Давтан эмчилгээ</Label>
    </Button>
  </Actions>
</Dialog>


<script>

import Dialog, {Title, Content, Actions} from '@smui/dialog';



</script>