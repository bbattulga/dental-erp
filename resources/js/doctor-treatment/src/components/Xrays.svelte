<div class="col-md-12">
	<ImageList class="my-image-list-masonry" masonry>
      {#each sources as src, i}
      <div class="card">
      	<div class="card-body">
	        <Item>
	          <Image src="{src}" />
	          <Supporting>
	            <Label>Image {i + 1}</Label>
	          </Supporting>
	        </Item>
	    </div>
	</div>
      {/each}
    </ImageList>
</div>


<script>


  import ImageList, {Item, ImageAspectContainer, 
  	Image, Supporting, Label} from '@smui/image-list';

	let sources = [
		'/img/xray.png',
		'/img/xray.png',
		'/img/xray.png',
		'/img/xray.png'
	];
</script>