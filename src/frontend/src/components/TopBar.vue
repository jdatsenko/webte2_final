<script setup>
import Button from "primevue/button";
import { useToast } from "primevue/usetoast";
import { router } from "../router";
import { changeLocale } from "../i18n";
import { t } from "@/i18n";
import { ref } from "vue";
import { exportToPDF } from "../manual";
import { Logout } from "@/api.js";

import { useUserStore } from "../stores/user.store";
const toast = useToast();
const { state } = useUserStore();

const logout = async () => {
  const res = await Logout.post();
  toast.add({
    severity: res.data.success ? "success" : "error",
    summary: res.data.success ? "Success" : "Error",
    detail: res.data.message,
  });
  if (!res.data.success) {
    return;
  }
  state.user = null;
  state.isLogged = false;
  router.push("/");
};

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleExportToPDF = () => {
  const data1 = document.getElementById("modalTitle");
  const data2 = document.getElementById("modalText");
  exportToPDF(data1, data2);
};

const isModalOpen = ref(false);
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
        v-tooltip="'Change language'"
      />
      <Button
        icon="pi pi-book"
        outlined
        @click="toggleModal()"
        v-tooltip="'Export manual to PDF'"
      />
      <Button
        v-if="!state.isLogged"
        icon="pi pi-user-plus"
        outlined
        @click="router.push('/register')"
        v-tooltip="'Register'"
      />
      <Button
        v-if="!state.isLogged"
        icon="pi pi-sign-in"
        @click="router.push('/login')"
        v-tooltip="'Login'"
      />
      <Button
        v-if="state.isLogged"
        icon="pi pi-sign-out"
        @click="logout()"
        outlined
        v-tooltip="'Logout'"
      />
      <Button
        v-if="state.isLogged"
        icon="pi pi-user"
        @click="router.push('/user')"
        v-tooltip="'Account'"
      />
    </div>
  </div>
  <div
    class="fixed items-center justify-center left-0 py-2 px-4"
    style="top: 6rem; z-index: 1000"
    v-if="isModalOpen"
  >
    <div class="bg-white rounded-lg shadow-2 p-6">
      <div class="flex align-items-center justify-content-between">
        <h2 id="modalTitle" class="text-xl font-bold">
          {{ t("App.modalTitle") }}
        </h2>
        <div class="flex gap-2">
          <Button icon="pi pi-download" outlined @click="handleExportToPDF" />
          <Button icon="pi pi-times" outlined @click="toggleModal" />
        </div>
      </div>
      <p id="modalText" class="text-sm">{{ t("App.modalText") }}</p>
    </div>
  </div>
</template>
