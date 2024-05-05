<template>
  <Toast />
  <div class="flex flex-column">
    <TopBar />
    <div class="px-4" style="margin-top: 6rem; min-height: calc(100vh-10rem);">
      <router-view/>
    </div>
  </div>
</template>

<script setup>
import TopBar from './components/TopBar.vue'; 
import Toast from 'primevue/toast';
</script>

<style>
</style>


