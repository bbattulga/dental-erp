import {writable} from 'svelte/store';

export const storeDoctors = writable([]);
export const storeShifts = writable([]);
export const storeTimes = writable([]);
export const storeSearch = writable(null);

export const storeUserBaseData = writable({});