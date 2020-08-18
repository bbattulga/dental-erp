import {writable} from 'svelte/store';
import moment from 'moment';


export const selectedTreatment = writable(0);
export const selectedTooth = writable(0);
export const toothStates = writable(new Array(49));
export const toothCodes = writable(new Array(49));
export const treatmentHistories = writable([]);
export const treatments = writable([]);

export const entryMode = writable(0);
export const checkin = writable(0);
export const patient = writable(0);
export const selectedTooths = writable([]);

export const decayChartValue = writable(0);

export const dateInterval = writable([new moment().format('YYYY-MM-DD'), new moment().format('YYYY-MM-DD')]);
export const dateIntervals = writable([]);

export const paintHistory = writable([]);
export const paintState = writable({
		tool: null,
		drawing: false,
		color: {r:10, g:11, b:12},
		weight: 10,
		canvasWidth: 0,
		canvasHeight: 0
	});

export const points = writable([]);