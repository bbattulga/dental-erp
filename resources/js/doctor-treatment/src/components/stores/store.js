import {writable} from 'svelte/store';

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

export const dateInterval = writable([new Date(), new Date()]);
export const dateIntervals = writable([]);