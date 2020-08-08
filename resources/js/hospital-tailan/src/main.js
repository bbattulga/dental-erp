import App from './App.svelte';
let target = document.getElementsByClassName('container-fluid')[0];
const app = new App({
	target: target
});

window.app = app;

export default app;