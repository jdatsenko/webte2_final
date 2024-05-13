<template>
    <div v-if="state.loading">
      <h1>Loading...</h1>
    </div>
    <div v-else-if="!state.question">
      <h1>Question not found</h1>
    </div>
    <div v-else>
      <h1>{{ state.question.question }}</h1>
      <p>{{ state.question.subject }}</p>
    </div>
  </template>
  
  <script setup>
  import { onMounted, defineProps, reactive } from 'vue';
  import { useQuestionStore } from '../stores/question.store';
  
  const props = defineProps(['code']);
  
  const state = reactive({
    question: null,
    loading: false,
    error: null,
  });
  
  const { getQuestion } = useQuestionStore();
  
  onMounted(async () => {
    if (state.question === null) {
      state.loading = true;
      try {
        const response = await getQuestion(props.code);
        state.question = response.data;
      } catch (error) {
        state.error = error;
      } finally {
        state.loading = false;
      }
    }
  });
  </script>
  