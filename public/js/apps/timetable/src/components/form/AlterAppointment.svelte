<script type="text/javascript">
	
	export let show = false;
	export let appointment;

</script>



{#if show}
<div class="form" target="#"
	on:click|stopPropagation>

		<header>
			<h1>{(appointment == null)? 'Цаг захиалах':'Захиалгын мэдээлэл'}</h1>
		</header>

		<div class="title-sub">
			<div>{doctor.name}</div>
			<div>{(start)+':00'} - {(end)%24+':00'}</div>
		</div>
		<!-- show input fields if user is null -->
		<!-- i.e no user in this cell -->
		{#if appointment == null}
		<div class="row-input">
			<label>Хугацаа(цагаар):</label> <br />
			<input type="number" bind:value={hours} style="max-width: 10%;">
		</div>
		{/if}

		<div class="row-input">
			<label>Үйлчлүүлэгчийн нэр:</label>
			<input bind:value={name}>
		</div>

		<div class="row-input">
			<label>Утас:</label>	
			<input bind:value={phone}>
		</div>

		<button 
			on:click|preventDefault|stopPropagation={handleSubmit}
			class="btn btn-add">ok</button>

	<button 
		class="btn-cancel"
		on:click|stopPropagation={close}>x</button>

		{#if appointment != null}
			<button on:click={handleDelete}>cancel</button>
		{/if}
</div>
{/if}