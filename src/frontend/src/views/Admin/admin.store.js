import { defineStore } from "pinia";
import { reactive } from "vue";
import { GetAllUsers } from "@/api";

export const useAdminStore = () =>
  defineStore("admin", () => {
    const state = reactive({
      users: [],
    });

    async function refetchUsers() {
      const res = await GetAllUsers.get();
      if (res.data.success) {
        state.users = res.data.data;
      }
      return res;
    }

    return { state, refetchUsers };
  })();
