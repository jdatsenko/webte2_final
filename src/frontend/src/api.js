import axios from "axios";

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

export const GetAllUsers = ((url) => ({
  get: () => {
    return axios.get(url);
  },
}))("/api/users/all");

export const ChangeUserPassword = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/changeUserPassword");

export const ChangeUserUsername = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/changeUserUsername");

export const DeleteUser = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/delete");

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
 * change Password
 */
export const ChangePassword = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/changePassword/");

/**
 * Make user admin
 * @param {number} id
 */
export const MakeUserAdmin = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/makeAdmin");

export const RevokeUserAdmin = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/users/revokeAdmin");

/**
 * Get user's questions
 * @param {number} id
 */
export const GetUserQuestions = ((url) => ({
  get: () => {
    return axios.get(url);
  },
}))("/api/users/getQuestions");

// ====================
// Questions
// ====================
/**
 * Get all questions
 */
export const GetAllQuestions = ((url) => ({
  get: () => {
    return axios.get(url);
  },
}))("/api/questions/all");

export const DeleteQuestion = ((url) => ({
  post: (code) => {
    return axios.post(url, code);
  },
}))("/api/questions/delete/");

export const GetQuestionByCode = ((url) => ({
  get: (code) => {
    return axios.get(url.replace("{code}", code));
  },
}))("/api/questions/{code}");

export const GetQuestionResults = ((url) => ({
  get: (code) => {
    return axios.get(url.replace("{code}", code));
  },
}))("/api/results/{code}");


export const CreateQuestion = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/questions/create");

export const ChangeQuestionStatus = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/questions/changeStatus");

export const DuplicateQuestion = ((url) => ({
  post: (code) => {
    console.log("Duplicating question with code: ", code);
    return axios.post(url, code);
  },
}))("/api/questions/duplicate/");

export const GetQuestionResponses = ((url) => ({
  post: (code) => {
    return axios.post(url, code);
  },
}))("/api/questions/getResponses/");

export const Answer = ((url) => ({
  post: (data) => {
    return axios.post(url, data);
  },
}))("/api/answers/create");

export const GetAllAnswers = ((url) => ({
  get: (code) => {
    return axios.get(url.replace("{code}", code));
  },
}))("/api/answers/{code}");
