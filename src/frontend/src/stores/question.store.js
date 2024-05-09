import { defineStore } from "pinia";
import { reactive } from "vue";
import { GetQuestionByCode } from "@/api";

export const useQuestionStore = () =>
  defineStore("question", () => {
    const state = reactive({
      question: null,
      loading: false,
      error: null,
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
