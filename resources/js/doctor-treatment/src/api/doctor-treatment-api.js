import axios from 'axios';

const range = (a, b) => {
    let list = [];
    for (let i = a; i <= b; i++) {
        list.push(i);
    }
    return list;
}

export const getToothCodes = () => {
	//return axios.post('/api/toothcodes');
	let toothCodes = new Array(32);
	toothCodes = [...toothCodes, ...range(11, 18)];
	toothCodes = [...toothCodes, ...range(21, 28)];
	toothCodes = [...toothCodes, ...range(31, 38)];
	toothCodes = [...toothCodes, ...range(41, 48)];
	return toothCodes;
}

export const getTreatments = () => {
	return axios.post('/api/treatments');
}

export const getTreatmentImgSrc = (toothCode, treatmentId) => {

	let path = '/img/toothImages/';
	let end = '';
	switch(treatmentId){
		case 3:
			end = '_burees.png';
			break;
		case 4:
			end = '_extraction.png';
			break;
		case 5:
			end = '_implant.png';
			break;
		case 6:
			end = '_paalan.png';
			break;
		case 7:
			end = '_post.png';
			break;
		case 8:
			end = '_post_cast.png';
			break;
		case 9:
			end = '_canal.png';
			break;
		default:
			end= '.png';
			break;
	}
	return `${path}${toothCode}${end}`;
}

/*
	required: [userId, checkinId, treatmentId, price]
	optional: [toothId, treatmetnSelectionId, value, decayLevel, toothTypeId
				symptom, diagnosis]

	note that toothId is requred in case of single treatments
*/
let fakeId = 1;
export const addUserTreatment = (userTreatment) => {

	let promise = new Promise((resolve, reject)=>{
		// ajax to store...
		let success = () => resolve(fakeId++);
		let fail = () => reject('user treatment rejected');
		setTimeout(success, 100);
	});
	return promise;
}

export const deleteUserTreatment = (userTreatmentId) => {

	let promise = new Promise((resolve, reject)=>{
		let success = () => resolve(fakeId++);
		let fail = () => alert('failed to delete usertreatment');
		setTimeout(success, 100);
	});
	return promise;
}