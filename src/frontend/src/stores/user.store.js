import { defineStore } from "pinia";
import { reactive } from "vue";

export const useUserStore = () =>
  defineStore("user", () => {
    const state = reactive({
      question: null,
      loading: false,
    });

    return { state };
  })();
