<script setup>
import Button from "primevue/button";
import { useToast } from "primevue/usetoast";
import { router } from "../router";
import { changeLocale } from "../i18n";
import { t } from "@/i18n";
import { ref } from "vue";
import { Logout } from "@/api.js";

import { useUserStore } from "../stores/user.store";
import { computed } from "vue";
const toast = useToast();
const { state } = useUserStore();

const logout = async () => {
  const res = await Logout.post();
  toast.add({
    severity: res.data.success ? "success" : "error",
    summary: res.data.success ? "Success" : "Error",
    detail: res.data.message,
    life: 3000,
  });
  if (!res.data.success) {
    return;
  }
  state.user = null;
  state.isLogged = false;
  router.push("/");
};
</script>

<template>
  <div
    class="fixed w-full h-4rem top-0 left-0 py-2 px-4 shadow-2 flex align-items-center justify-content-between"
    style="z-index: 999"
  >
    <div class="flex items-center justify-center">
      <span
        class="text-lg font-bold cursor-pointer hover:text-blue-500"
        @click="router.push('/')"
      >
        {{ t("App.title") }}
      </span>
      <span
        v-if="state.isLogged"
        class="text-lg font-bold cursor-pointer ml-4 hover:text-blue-500"
        @click="router.push('/create')"
      >
        {{ t("App.create") }}
      </span>
    </div>
    <div class="flex gap-2">
      <Button
        icon="pi pi-globe"
        outlined
        @click="changeLocale()"
        v-tooltip="{ value: 'Change language', showDelay: 500, hideDelay: 300 }"
      />
      <Button
        icon="pi pi-book"
        outlined
        @click="router.push('/manual')"
        v-tooltip="{
          value: 'User Manual',
          showDelay: 500,
          hideDelay: 300,
        }"
      />
      <Button
        v-if="!state.isLogged"
        icon="pi pi-user-plus"
        outlined
        @click="router.push('/register')"
        v-tooltip="{ value: 'Register', showDelay: 500, hideDelay: 300 }"
      />
      <Button
        v-if="!state.isLogged"
        icon="pi pi-sign-in"
        @click="router.push('/login')"
        v-tooltip="{ value: 'Login', showDelay: 500, hideDelay: 300 }"
      />
      <Button
        v-if="state.isLogged"
        icon="pi pi-sign-out"
        @click="logout()"
        outlined
        v-tooltip="{ value: 'Logout', showDelay: 500, hideDelay: 300 }"
      />
      <Button
        v-if="state.isLogged"
        icon="pi pi-user"
        @click="router.push('/user')"
        v-tooltip="{ value: 'Account', showDelay: 500, hideDelay: 300 }"
      />
      <Button
        v-if="state.user?.isAdmin"
        icon="pi pi-crown"
        @click="router.push('/admin')"
        v-tooltip="{ value: 'Admin', showDelay: 500, hideDelay: 300 }"
      />
    </div>
  </div>
</template>
