<script setup>
import { t } from "@/i18n";

const { code } = defineProps(["code"]);
</script>

<template>
  <div class="container">
    <h1 class="text">Question: {{ code }}</h1>
  </div>
</template>

<style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40vh;
}

.text {
  color: rgb(164, 63, 63);
  font-size: 40px;
  text-align: center;
}
</style>
