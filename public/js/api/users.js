
import axios from 'axios';

const baseUrl = '/api/users/';


const create = (user) => {
	return axios.post(`${baseUrl}/create`, user);
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