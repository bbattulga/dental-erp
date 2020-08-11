<Dialog
  bind:this={dialog}
  aria-labelledby="dialog-title"
  aria-describedby="dialog-content"
>
  <Title id="dialog-title">Delete Item</Title>
  <Content id="dialog-content">
    Are you sure you want to delete the item?
  </Content>
  <Actions>
    <Button>
      <Label>Cancel</Label>
    </Button>
    <Button>
      <Label>Delete</Label>
    </Button>
  </Actions>
</Dialog>


<script>

	import Dialog, {Title, Content, Actions} from '@smui/dialog';
  	import Button, {Label} from '@smui/button';

  	export let dialog;
</script>