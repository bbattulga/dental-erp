export const checkinStateName = (code) => {
	let m = ['хүлээгдэж байна', 'эмчилгээнд орж байна', 'эмчилгээ дууссан', 'төлбөр төлөгдсөн']
	if (code >=0 && (code < m.length)){
		return m[code];
	}
	return null;
}
