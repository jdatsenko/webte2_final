<script setup>
import { onMounted, ref, reactive, toRaw } from "vue";
import { useQuestionStore } from "../stores/question.store";
import { t } from "@/i18n";
import Fieldset from "primevue/fieldset";
import { Answer } from "@/api";

import Checkbox from "primevue/checkbox";
import Button from "primevue/button";
import { useToast } from "primevue/usetoast";
import { router } from "../router";

import Textarea from "primevue/textarea";

import FloatLabel from "primevue/floatlabel";

const { state, getQuestion } = useQuestionStore();
const { code } = defineProps(["code"]);
const selectedAnswers = ref();
const toast = useToast();

const answerData = reactive({
  questionID: "",
  answerID: [],
  text: "",
});

const answer = async () => {
  const rawObjectOrArray = toRaw(state);
  answerData.questionID = rawObjectOrArray.question.id;
  if (state.question.type === "choice") {
    const allAnswers = rawObjectOrArray.answers;
    for (let i = 0; i < selectedAnswers.value.length; i++) {
      for (let j = 0; j < allAnswers.length; j++) {
        if (selectedAnswers.value[i] === allAnswers[j].answer) {
          answerData.answerID.push(allAnswers[j].id);
        }
      }
    }
    if (
      selectedAnswers.value.length == 0 ||
      typeof selectedAnswers === "undefined"
    ) {
      toast.add({
        severity: "error",
        summary: "Error",
        detail: "You didn't select an answer",
        life: 3000,
      });
      return;
    }
  }
  if (state.question.type === "answer" && answerData.text === "") {
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "You didn't fill your answer",
      life: 3000,
    });
    return;
  }
  const response = await Answer.post(answerData);
  toast.add({
    severity: response.data.success ? "success" : "error",
    summary: response.data.success ? "Success" : "Error",
    detail: response.data.message,
    life: 3000,
  });

  if (response.data.success) {
    router.push(`/result/${code}`);
  }
};

onMounted(async () => {
  if (state.question === null || state.question.code !== code) {
    await getQuestion(code);
  }
});
</script>

<template>
  <div v-if="state.loading">
    <h1>Loading...</h1>
  </div>
  <div v-else-if="state.question == null">
    <h1>{{ t("Question.not-found") }}</h1>
  </div>
  <div v-else>
    <div class="card flex justify-content-center">
      <Fieldset :legend="state.question.subject" style="width: 50%">
        <h1>{{ state.question.question }}</h1>
        <div class="card flex">
          <div class="flex flex-column gap-3">
            <div
              v-if="state.question.type === 'choice'"
              v-for="(answer, index) in state.answers"
              :key="index"
              class="flex align-items-center"
            >
              <Checkbox
                v-model="selectedAnswers"
                :inputId="'answer' + index"
                name="answers"
                :value="answer.answer"
              />
              <label :for="'answer' + index" class="ml-2">{{
                answer.answer
              }}</label>
            </div>
            <div
              v-if="state.question.type === 'answer'"
              class="card flex justify-content-center"
            >
              <FloatLabel>
                <Textarea v-model="answerData.text" rows="5" cols="30" />
                <label>Answer</label>
              </FloatLabel>
            </div>
          </div>
        </div>
        <div class="flex justify-content-end">
          <Button label="Answer" @click="answer" />
        </div>
      </Fieldset>
    </div>
  </div>
</template>
