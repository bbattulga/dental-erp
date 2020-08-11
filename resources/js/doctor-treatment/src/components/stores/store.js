import {writable} from 'svelte/store';

export const selectedTreatment = writable({});
export const selectedTooth = writable({});
export const toothStates = writable({});
export const treatmentHistories = writable([]);

export const checkin = writable({});
export const patient = writable({});
export const selectedTooths = writable([]);