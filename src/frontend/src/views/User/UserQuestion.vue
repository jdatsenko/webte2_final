<script setup>
import { t } from "@/i18n";
import { ref, onMounted } from "vue";
import { GetQuestionResponses } from "@/api";
import { useToast } from "primevue/usetoast";
import { router } from "../../router";
import Button from "primevue/button";

const toast = useToast();
const { code } = defineProps(["code"]);

const responses = ref([]);
const question = ref({});

onMounted(async () => {
  const res = await GetQuestionResponses.post({ code });
  if (res.data.success) {
    responses.value = res.data.data.responses;
    question.value = res.data.data.question;
  } else {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: res.data.message,
    });
  }
});
</script>

<template>
  <div class="flex flex-column justify-content-center">
    <div class="flex gap-4 align-items-center flex-row">
      <Button
        @click="router.back()"
        icon="pi pi-chevron-left"
        v-tooltip="{ value: 'Back', showDelay: 1000, hideDelay: 300 }"
      />
      <h1>
        {{ question.question }}
      </h1>
    </div>
  </div>
</template>

<style></style>
