

// 9.5 -> 09:30
// 12.25 -> 12:15
// 13.75 -> 12:45
export const floatToTime = (floatTime) => {

	let hour = Math.floor(floatTime);
	let min = 60*(floatTime - hour);

	// add 9:5 -> 9:5
	// add 9:5 -> 09:05
	hour = hour<10? '0'+hour: hour;
	min = min<10? '0'+min: min;

	return `${hour}:${min}`;
}

// 09:00 -> 9.0
// 09:30 -> 9.5
export const timeToFloat = (timeStr) => {
	let colon = timeStr.indexOf(':');
	let hour = parseInt(timeStr.slice(0, colon));
	let min = parseInt(timeStr.slice(colon+1, timeStr.length));
	min /= 60;
	return hour+min;
}