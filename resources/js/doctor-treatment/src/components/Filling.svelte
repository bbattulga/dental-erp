<svg height="25" width="25">
    <polygon id="pl-0" points="0,0 12.5,12.5 25,0" />
    <polygon id="pl-1" points="12.5,12.5 25,0 25,25" />
    <polygon id="pl-2" points="0,25 12.5,12.5 25,25" />
    <polygon id="pl-3" points="0,0 12.5,12.5 0,25" />
    <circle id="pl-4" cx="12.5" cy="12.5" r="6.25" />
</svg>



<script>
	export let value = 0;
    let v = value.toString(2);
    let prefix = '';
    for (let i=0; i<5-v.length; i++){
    	prefix += '0';
    }
    v = prefix+v;
    console.log(document.getElementById(`pl-${0}`));
    // for (let i=0; i<v.length; i++){
    // 	let pl = document.getElementById(`pl-${i}`);
    // 	if (v[i] == 1){
    // 		pl.style.fill = '#138496';
    // 	}
    // }
</script>