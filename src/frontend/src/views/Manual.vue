<script setup>
import { router } from "@/router";
import Button from "primevue/button";
import { t } from "@/i18n";
import { exportToPDF } from "@/manual";

const handleExportToPDF = () => {
  const data1 = document.getElementById("modalTitle");
  const data2 = document.getElementById("modalText");
  exportToPDF(data1, data2);
};
</script>

<template>
  <div class="flex flex-column justify-content-center">
    <div class="flex gap-4 align-items-center flex-row">
      <Button
        @click="router.back()"
        icon="pi pi-chevron-left"
        v-tooltip="{ value: 'Back', showDelay: 1000, hideDelay: 300 }"
      />
      <h1>User Manual</h1>
    </div>
    <div class="flex align-items-center justify-content-between">
      <h2 id="modalTitle" class="text-xl font-bold">
        {{ t("App.modalTitle") }}
      </h2>
      <div class="flex gap-2">
        <Button icon="pi pi-download" outlined @click="handleExportToPDF" />
      </div>
    </div>
    <p id="modalText" class="text-sm">
      <span class="title">{{ t("App.modalText.part1") }}</span>
      <br />
      <span class="main-text">{{ t("App.modalText.part2") }}</span>
      <br />
      <span class="title">{{ t("App.modalText.part3") }}</span>
      <span class="main-text">
        <ul>
          <li>
            {{ t("App.modalText.part4.0.step") }}.
            {{ t("App.modalText.part4.0.description") }}
          </li>
          <li>
            {{ t("App.modalText.part4.1.step") }}.
            {{ t("App.modalText.part4.1.description") }}
          </li>
          <li>
            {{ t("App.modalText.part4.2.step") }}.
            {{ t("App.modalText.part4.2.description") }}
          </li>
        </ul>
      </span>
      <span class="title">{{ t("App.modalText.part5") }}</span>
      <br />
      <span class="main-text">
        <ul>
          <li>
            {{ t("App.modalText.part6.0.step") }}.
            {{ t("App.modalText.part6.0.description") }}
          </li>
          <li>
            {{ t("App.modalText.part6.1.step") }}.
            {{ t("App.modalText.part6.1.description") }}
          </li>
        </ul>
      </span>
      <span class="title">{{ t("App.modalText.part7") }}</span>
      <span class="main-text">
        <ul>
          <li>
            {{ t("App.modalText.part8.0.step") }}.
            {{ t("App.modalText.part8.0.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.1.step") }}.
            {{ t("App.modalText.part8.1.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.2.step") }}.
            {{ t("App.modalText.part8.2.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.3.step") }}.
            {{ t("App.modalText.part8.3.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.4.step") }}.
            {{ t("App.modalText.part8.4.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.5.step") }}.
            {{ t("App.modalText.part8.5.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.6.step") }}.
            {{ t("App.modalText.part8.6.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.7.step") }}.
            {{ t("App.modalText.part8.7.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.8.step") }}.
            {{ t("App.modalText.part8.8.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.9.step") }}.
            {{ t("App.modalText.part8.9.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.10.step") }}.
            {{ t("App.modalText.part8.10.description") }}
          </li>
          <li>
            {{ t("App.modalText.part8.11.step") }}.
            {{ t("App.modalText.part8.11.description") }}
          </li>
        </ul>
      </span>
      <span class="title">{{ t("App.modalText.part9") }}</span>
      <span class="main-text">
        <ul>
          <li>
            {{ t("App.modalText.part10.0.step") }}.
            {{ t("App.modalText.part10.0.description") }}
          </li>
          <li>
            {{ t("App.modalText.part10.1.step") }}.
            {{ t("App.modalText.part10.1.description") }}
          </li>
          <li>
            {{ t("App.modalText.part10.2.step") }}.
            {{ t("App.modalText.part10.2.description") }}
          </li>
          <li>
            {{ t("App.modalText.part10.3.step") }}.
            {{ t("App.modalText.part10.3.description") }}
          </li>
        </ul>
      </span>
    </p>
  </div>
</template>

<style scoped>
#modalText {
  font-family: Arial, sans-serif;
}

.title {
  font-size: 1.5em; /* Title size */
  font-weight: bold; /* Make it bold to look like a title */
  color: #333; /* Darker color for the title */
  margin-bottom: 10px; /* Space between title and text */
}

.main-text {
  font-size: 1em; /* Normal text size */
  font-weight: normal; /* Normal weight */
  color: #666; /* Lighter color for the text */
  line-height: 1.5; /* Better readability */
}
</style>
