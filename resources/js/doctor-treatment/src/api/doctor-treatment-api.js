import axios from 'axios';

export const finishTreatment = (data) => {
	return axios.put('/api/user-treatment/finish', data);
}

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

export const fetchTreatments = () => {
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
export const addUserTreatment = (userTreatment) => {
	return axios.post('/api/user-treatment/create', userTreatment);
}

export const fetchUserTreatments = (userId) => {
	let data = {
		user_id: userId
	}
	return axios.post('/api/user-treatment/query', data);
}

export const updateUserTreatment = (userTreatment) => {
	return axios.post('/api/user-treatment/update', userTreatment);
}

export const deleteUserTreatment = (userTreatmentId) => {

	if (typeof userTreatmentId !=='number'){
		console.log('warning: ', userTreatmentId, 'is not a id for treatment history');
		return new Promise((resolve, reject) => resolve(1)); // says just delete that
	}
	return axios.delete(`/api/user-treatment/delete/${userTreatmentId}`);
}

// note
export const saveNote = (data) => {
	return axios.post('/api/user-treatment/update', data);
}

// xrays
export const fetchXrays = (userId) => {
	let data = {
		user_id: userId
	}
	return axios.post('/api/xray', data);
}

export const deleteImage = (imageId) => {
	return axios.delete(`/api/xray/delete/${imageId}`);
}

export const uploadImage = (data) => {
	return axios.post('/api/xray/create', data);
}

// paintings

export const fetchPaintings = (data) => {
	return axios.post('/api/paint/user', data);
}

export const addPainting = (data) => {
	return axios.post('/api/paint/create', data);
}

export const updatePainting = (data) => {
	return axios.put('/api/paint/update', data);
}