import axios from 'axios'

const instance = axios.create({
    baseURL: 'http://poke-server.therigan.com/api'
});

export default instance