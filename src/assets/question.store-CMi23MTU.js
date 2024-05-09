import { G as defineStore, l as reactive } from "./index-sPSBL-rk.js";
import { G as GetQuestionByCode } from "./api-Dk7U0UxE.js";
const useQuestionStore = () => defineStore("question", () => {
  const state = reactive({
    question: null,
    loading: false,
    error: null
  });
  const getQuestion = async (code) => {
    state.loading = true;
    try {
      const response = await GetQuestionByCode.get(code);
      state.question = response.data;
    } catch (error) {
      state.error = error;
    } finally {
      state.loading = false;
    }
  };
  return { state, getQuestion };
})();
export {
  useQuestionStore as u
};
