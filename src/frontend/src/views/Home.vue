<script setup>
import Button from "primevue/button";
import { router } from "../router";
import InputOtp from "primevue/inputotp";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { t } from "@/i18n";
import { useQuestionStore } from "../stores/question.store";

const code = ref("");
const toast = useToast();
const { state, getQuestion } = useQuestionStore();
const handleJoin = async () => {
  console.log("Code:", code.value);
  state.question = null;
  state.answers = [];
  if (code.value.length !== 5) {
    toast.add({
      severity: "error",
      summary: "Invalid Code",
      detail: "Code must be 5 characters long",
      life: 3000,
    });
    return;
  } else if (/^[a-z0-9]+$/i.test(code.value) === false) {
    toast.add({
      severity: "error",
      summary: "Invalid Code",
      detail: "Code must contain only letters and numbers",
      life: 3000,
    });
    return;
  }
  await getQuestion(code.value);
  if (state.question === null) {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: state.error,
      life: 3000,
    });
    return;
  }
  router.push(`/question/${code.value}`);
};
</script>

<template>
  <div class="flex flex-column gap-2 align-items-center">
    <h1>{{ t("Home.join-a-question") }}</h1>
    <InputOtp v-model="code" :length="5" />
    <Button
      :loading="state.loading"
      :label="t('Home.button-join')"
      @click="handleJoin"
    />
  </div>
</template>
