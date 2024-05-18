import { defineStore } from "pinia";
import { reactive } from "vue";
import { GetUserInfo, GetUserQuestions } from "@/api";

export const useUserStore = () =>
  defineStore("user", () => {
    const state = reactive({
      user: null,
      isLogged: false,
      questions: [],
    });

    async function getUserInfo() {
      const res = await GetUserInfo.get();
      if (res.data.success) {
        state.user = res.data.data;
        state.isLogged = true;
        return;
      }
      state.user = null;
      state.isLogged = false;
    }

    async function getUserQuestions() {
      state.questions = [];
      const res = await GetUserQuestions.get();
      if (res.data.success) {
        state.questions = res.data.data;
      }
    }

    return { state, getUserInfo, getUserQuestions };
  })();
