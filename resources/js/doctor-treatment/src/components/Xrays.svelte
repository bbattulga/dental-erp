<div class="col-md-12">

	<div class="card mb-3">
		<div class="card-body">
			<div>
				<form bind:this={imgSubmitForm}
					on:submit|preventDefault={handleSubmit}
					method="POST" action="/doctor/treatment/xray" enctype="multipart/form-data">
					<input type="hidden" name="user_id" value={$patient.id}>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">
								Зураг оруулах
							</span>
						</div>
	                    <div class="custom-file input-group-text">
		                    <input bind:this={imgUpload} type="file" accept="image/*" name="image">
	                    </div>
	                    <div class="input-group-append">
	                        <button type="submit" class="btn btn-primary">Оруулах</button>
	                    </div>
	                </div>
				</form>
			</div>
		</div>
	</div>

      {#each xrays as xray (xray.id)}
      <div class="card mb-3" style="overflow: auto;">
		<div style="position: absolute;
			right: 3px;
			cursor: pointer;
			font-size: 2rem;
			top: 3px;" on:click={() => handleDelete(xray)}
		class="glyph-icon simple-icon-close"></div>

      	<div class="card-body">

	          <img id="photo-{xray.id}" src="/storage/img/xray/{xray.path}">
	          <div>
		          {new moment(xray.created_at).format('YYYY-MM-DD HH:mm:ss')}
		      </div>
	     </div>
      </div>
      {/each}
</div>


<script>


  import ImageList, {Item, ImageAspectContainer, 
  	Image, Supporting, Label} from '@smui/image-list';


  	import {patient} from './stores/store.js';
  	import FormData from 'form-data';

  	import { uploadImage, 
  			deleteImage,
  			fetchXrays } from '../api/doctor-treatment-api.js';

  	import moment from 'moment';


	let xrays = [];

	fetchXrays($patient.id).then(response => {
		xrays = response.data;
		console.log('fetched xrays');
		console.log(xrays);
	})

	let imgSubmitForm;
	let imgUpload;
	const handleSubmit = (event) => {
        var formData = new FormData(imgSubmitForm);
        uploadImage(formData)
        	.then(response => {
	        	let xray = response.data;
	        	xrays = [xray, ...xrays];
        	})
        	.catch(err => {
        		console.log('Зураг хадгалахад алдаа гарлаа');
        		console.log(err);
        	})
	}

	const handleDelete = (image) => {

		if (!confirm(`${image.path} -г устгах уу?`)){
			return;
		}
		deleteImage(image.id).then(response => {
			xrays = xrays.filter(x => x.id != image.id);
		})
		.catch(err => {
			alert('зураг устгахад алдаа гарлаа\nдахиж оролдоно уу');
			console.log(err);
		})
	}
</script>