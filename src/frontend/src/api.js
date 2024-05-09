import axios from "axios";

export const GetQuestionByCode = ((url) => ({
  get: (code) => {
    return axios.get(url.replace("{code}", code));
  },
}))("/api/questions/{code}");

// ====================
// Users
// ====================

/**
 * Get user info
 * @param {number} id
 */
export const GetUserInfo = ((url) => ({
  get: (id) => {
    return axios.get(url.replace("{id}", id));
  },
}))("/api/users/getInfo");

/**
 * Login
 */
export const Login = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/login");

/**
 * Register
 * @param {string} login
 * @param {string} password
 * @param {string} usesrname
 */
export const Register = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/register/");

/**
 * Logout
 */
export const Logout = ((url) => ({
  post: () => {
    return axios.post(url);
  },
}))("/api/users/logout");

/**
 * Make user admin
 * @param {number} id
 */
export const MakeUserAdmin = ((url) => ({
  post: (id) => {
    return axios.post(url, id);
  },
}))("/api/users/makeAdmin");
