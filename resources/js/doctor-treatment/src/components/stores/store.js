import {writable} from 'svelte/store';

export const selectedTreatment = writable(0);
export const selectedTooth = writable(0);
export const toothStates = writable(new Array(49));
export const toothCodes = writable(new Array(49));
export const treatmentHistories = writable([]);

export const checkin = writable({});
export const patient = writable({});
export const selectedTooths = writable([]);

export const decayChartValue = writable(0);