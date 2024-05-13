import { defineStore } from "pinia";
import { reactive } from "vue";
import { GetUserInfo } from "@/api";

export const useUserStore = () =>
  defineStore("user", () => {
    const state = reactive({
      user: null,
      isLogged: false,
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

    return { state, isAdmin, getUserInfo };
  })();
