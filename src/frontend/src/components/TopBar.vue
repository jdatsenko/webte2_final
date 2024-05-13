<template>
  <div v-if="!loading">
  <div class="fixed w-full h-4rem top-0 left-0 py-2 px-4 shadow-2 flex align-items-center justify-content-between" style="z-index: 999;">
    <div class="flex items-center justify-center">
      <span class="text-lg font-bold cursor-pointer" @click="router.push('/')">{{ t('App.title') }}</span>
      <span v-show="isLoggedIn" class="text-lg font-bold cursor-pointer ml-4" @click="router.push('/create')">Create</span>
  </div>
      <div class="flex gap-2">
          <Button icon="pi pi-globe" outlined @click="changeLocale()" />
          <Button v-show="!isLoggedIn" icon="pi pi-user-plus" outlined @click="router.push('/register')" />
          <Button icon="pi pi-book" outlined @click="toggleModal()"/>
          <Button v-show="!isLoggedIn" icon="pi pi-sign-in" @click="router.push('/login')" />
      </div>
  </div>
  <div class="fixed items-center justify-center left-0 py-2 px-4" style="top: 6rem;z-index: 1000" v-if="isModalOpen">
    <div class="bg-white rounded-lg shadow-2 p-6">
      <div class="flex align-items-center justify-content-between">
        <h2 id="modalTitle" class="text-xl font-bold">{{ t('App.modalTitle') }}</h2>
        <div class="flex gap-2">
          <Button icon="pi pi-download" outlined @click="handleExportToPDF"/>
          <Button icon="pi pi-times" outlined @click="toggleModal" />
        </div>
      </div>
      <p id="modalText" class="text-sm">{{ t('App.modalText') }}</p>
    </div>
  </div>
</div>
</template>

<script setup>
import Button from 'primevue/button';
import { router } from "../router";
import { changeLocale } from "../i18n";
import { t } from "@/i18n";
import { ref } from 'vue';
import { exportToPDF } from '../manual';
import { IsLoggedIn } from '@/api.js';

const isModalOpen = ref(false);
const isLoggedIn = ref(false);
const loading = ref(true); 
IsLoggedIn.get()
  .then(response => {
      isLoggedIn.value = response.data.isLoggedIn;
  })
  .catch(error => {
      console.error('Error fetching authentication status:', error);
  })
  .finally(() => {
      loading.value = false; 
  });

const toggleModal = () => {
  isModalOpen.value = !isModalOpen.value;
};

const handleExportToPDF = () => {
  const data1 = document.getElementById("modalTitle");
  const data2 = document.getElementById("modalText");
  exportToPDF(data1, data2);
};
</script>
