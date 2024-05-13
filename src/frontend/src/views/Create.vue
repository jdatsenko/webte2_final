<script setup>
import { t } from "@/i18n";
import { reactive, computed, ref } from "vue";
import { useToast } from "primevue/usetoast";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import Checkbox from "primevue/checkbox";
import Button from "primevue/button";

import { CreateQuestion } from "@/api";
import { router } from "../router";

const toast = useToast();

const questionTypes = ref([
  {
    label: "Choice",
    value: "choice",
  },
  {
    label: "Open answer",
    value: "answer",
  },
]);

const question = reactive({
  type: "choice",
  text: "",
  subject: "",
  answers: [
    {
      answer: "",
      isRight: false,
    },
  ],
});

const isSelectedAtLeastOneRightAnswer = computed(() => {
  return question.answers.some((answer) => answer.isRight);
});

const isSomeFieldEmpty = computed(() => {
  return (
    question.text.trim() === "" ||
    question.subject.trim() === "" ||
    question.answers.some((answer) => answer.answer.trim() === "")
  );
});

const createQuestion = async () => {
  if (question.type === "answer") {
    toast.add({
      severity: "error",
      summary: "Invalid Input",
      detail: "Open answer questions are not supported yet",
    });
  }

  if (isSomeFieldEmpty.value) {
    toast.add({
      severity: "error",
      summary: "Invalid Input",
      detail: "Fill all the fields",
    });
    return;
  }

  if (question.answers.length < 2) {
    toast.add({
      severity: "error",
      summary: "Invalid Input",
      detail: "You need to add at least two answers",
    });
    return;
  }

  if (!isSelectedAtLeastOneRightAnswer.value) {
    toast.add({
      severity: "error",
      summary: "Invalid Input",
      detail: "You need to select at least one right answer",
    });
    return;
  }

  const response = await CreateQuestion.post(question);
  if (response.data.success) {
    toast.add({
      severity: "success",
      summary: "Success",
      detail: response.data.message,
    });
    router.push({
      name: "questionStats",
      params: { code: response.data.code },
    });
  } else {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: response.data.message,
    });
  }
};

function addAnswer() {
  question.answers.push({
    answer: "",
    isRight: false,
  });
}

function removeAnswer(index) {
  question.answers.splice(index, 1);
}
</script>

<template>
  <div class="flex flex-column align-items-center justify-content-center">
    <h1>{{ t("Create.title") }}</h1>

    <Dropdown
      v-model="question.type"
      :options="questionTypes"
      optionLabel="label"
      optionValue="value"
      class="mb-2 w-22rem"
    />
    <div class="field mb-2">
      <label for="subject" class="block">{{ t("Create.subject") }}</label>
      <InputText
        id="subject"
        type="text"
        v-model="question.subject"
        class="w-22rem"
        max="255"
      />
    </div>
    <div class="field mb-4">
      <label for="question" class="block">{{ t("Create.question") }}</label>
      <InputText
        id="question"
        type="text"
        v-model="question.text"
        class="w-22rem"
      />
    </div>

    <div
      v-for="(answer, index) in question.answers"
      v-if="question.type === 'choice'"
      :key="index"
      class="flex flex-row align-items-center mb-2 gap-2"
    >
      <Checkbox
        v-model="answer.isRight"
        :binary="true"
        v-tooltip="'Is this the right answer?'"
      />
      <InputText
        :placeholder="`Answer ${index + 1}`"
        type="text"
        v-model="answer.answer"
        class="w-17rem"
      />
      <Button
        v-if="question.answers.length == index + 1"
        @click="addAnswer"
        icon="pi pi-plus"
      />
      <Button
        v-else
        severity="danger"
        @click="removeAnswer(index)"
        icon="pi pi-minus"
      />
    </div>

    <div class="flex align-items-center justify-content-center">
      <Button @click="createQuestion">
        {{ t("Create.button-create") }}
      </Button>
    </div>
  </div>
</template>
