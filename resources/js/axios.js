/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import { cookies } from "brownies"

let config = axios;

config.defaults = {
    headers: {
        common: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        'X-XSRF-TOKEN': cookies['X-XSRF-TOKEN']
    },
    // baseURL: "http://localhost/api/",
    baseURL: "http://localhost/",
}

// config.interceptors.request.use(
//     (request) => {
//         if (!cookies['XSRF-TOKEN'])
//             axios.get("http://localhost/sanctum/csrf-cookie")

//         return request;
//     },
//     (error) => console.error(error)
// );

window.axios = config;

// class AjaxRequest {

//     #SANCTUM_CSRF = "http://localhost/sanctum/csrf-cookie";

//     #axios = axios;

//     constructor() {
//         // this.#axios = axios;
//         this.#axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//         this.#axios.defaults.validateStatus = () => true;
//         this.#axios.defaults.baseURL = "http://localhost/api/";
//     }

//     async login(username = '', password = '') {
//         try {

//             if (!cookies['XSRF-TOKEN'])
//                 (await this.get(this.#SANCTUM_CSRF)).data

//             axios.post('http://localhost/user/login', { username, password }, {
//                 headers: {
//                     "X-XSRF-TOKEN": cookies['XSRF-TOKEN']
//                 }
//             })

//         } catch (error) {
//             console.error(error);
//         }
//     }

//     async get(url) {
//         try {
//             return (await this.#axios.get(url)).data
//         } catch (error) {
//             console.error(error);
//         }
//     }

//     async post(url, data = {}) {
//         try {
//             return (await this.#axios.post(url, data)).data
//         } catch (error) {
//             console.error(error)
//         }
//     }

// }

// export { AjaxRequest }
