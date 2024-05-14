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

    const isAdmin = () => state.user?.role === "admin";

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
      const res = await GetUserQuestions.get(state.user.id);
      if (res.data.success) {
        state.questions = res.data.data;
      }
    }

    return { state, isAdmin, getUserInfo, getUserQuestions };
  })();
