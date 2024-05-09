import axios from 'axios';

export const GetQuestionByCode = ((url) => ({
    get: (code) => {
        return axios.get(url.replace('{code}', code));
    }
}))('/api/questions/get/{code}')