<script setup>
import { onMounted } from 'vue';
import { useQuestionStore } from '../stores/question.store';

import Fieldset from 'primevue/fieldset';

import RadioButton from 'primevue/radiobutton';

const { state, getQuestion } = useQuestionStore();

const { code } = defineProps(['code']);

onMounted(async () => {
    if (state.question === null) {
        await getQuestion(code);
    }
})
</script>

<template>
    <div v-if="state.loading">
        <h1>Loading...</h1>
    </div>
    <div v-else-if="state.question == null">
        <h1>{{ t('Question.not-found') }}</h1>
    </div>
    <div v-else>
        <div class="card flex justify-content-center">
    <Fieldset :legend="state.question.subject" style="width: 50%;">
      <h1>{{ state.question.question }}</h1>
      <div class="card flex">
      <div class="flex flex-column gap-3">
        <div v-for="(answer, index) in state.answers" :key="index" class="flex align-items-center">
          <RadioButton v-model="selectedAnswer" :inputId="'answer' + index" name="answers" :value="answer" />
          <label :for="'answer' + index" class="ml-2">{{ answer }}</label>
        </div>
      </div>
    </div>
    </Fieldset>
  </div>
    
    </div>
</template>