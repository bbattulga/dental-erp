
import axios from 'axios';

const baseUrl = '/api/appointments';

const create = (appointment) => {
	return axios.post(`${baseUrl}/create`, appointment);
}

const show = (id) => {
	return axios.get(`${baseUrl}/${id}`);
}

const update = (data) => {
	return axios.put(`${baseUrl}/update`, data);
}

const destroy = (id) => {
	return axios.delete(`${baseUrl}/delete/${id}`);
}