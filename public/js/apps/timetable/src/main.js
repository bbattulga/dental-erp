import App from './App.svelte';
import Calendar from './components/Calendar.svelte';

const app = new App({
	target: document.getElementById('timetable')
});

const calendar = new Calendar({
	target: document.getElementById('timetable-calendar')
});

export default app;