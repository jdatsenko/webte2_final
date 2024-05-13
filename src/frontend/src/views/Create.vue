<template>
    <div class="flex flex-column align-items-center justify-content-center">
      <h1>{{ t('Create.title') }}</h1>
      <form @submit.prevent="handleSubmit" class="flex flex-column mx-auto grid justify-content-center">
        <div class="flex flex-column align-items-center justify-content-center">
          <div class="field mb-2">
            <label for="question" class="block">{{ t('Create.question') }}</label>
            <InputText id="question" type="text" v-model="questionText" class="input-lg"/>
          </div>
          <div class="field mb-2">
            <label for="subject" class="block">{{ t('Create.subject') }}</label>
            <InputText id="subject" type="text" v-model="subject" class="input-lg"/>
          </div>
  
          <div v-for="(answer, index) in answers" :key="index" class="field mb-2">
            <div class="flex align-items-center">
              <Checkbox v-model="checked[index]" :binary="true" class="mr-2 mb-1"/>
              <label :for="'answer' + index" class="block">{{ t('Create.answer') }} {{ index + 1 }}:</label>
            </div>
            <InputText :id="'answer' + index" type="text" v-model="answers[index]" class="input-lg"/>
          </div>
          
          <div class="flex align-items-center justify-content-center">
            <Button type="submit">{{ $t('Create.button-create') }}</Button>
          </div>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { t } from "@/i18n";
  import axios from 'axios';
  import { ref } from 'vue';
  import { useToast } from 'primevue/usetoast';
  import InputText from 'primevue/inputtext';
  import Checkbox from 'primevue/checkbox';
  import Button from 'primevue/button';
  import { router } from "../router";
  const toast = useToast();
  
  const questionText = ref('');
    const subject = ref('');
  const answers = ref(['', '', '', '']);
  const checked = ref([false, false, false, false]);
  
  const handleSubmit = () => {
  if (
    questionText.value.trim() === '' ||
    subject.value.trim() === '' ||
    answers.value.some(answer => answer.trim() === '')
  ) {
    toast.add({ severity: 'error', summary: 'Invalid Input', detail: 'Fill all the fields' });
    return;
  }
  
  if (!checked.value.includes(true)) {
    toast.add({ severity: 'error', summary: 'Invalid Input', detail: 'You need to select one right answer' });
    return;
  }
  
  // Prepare the data to be sent to the backend
  const questionData = {
    type: 'choice', // Assuming the question type is always 'choice'
    subject: subject.value,
    question: questionText.value,
    answers: answers.value.map((answer, index) => ({
      answer: answer.trim(),
      isRight: checked.value[index]
    }))
  };

  axios.post('/api/questions/create', questionData)
  .then(response => {
    console.log('Question created successfully:', response.data);
    const questionCode = response.data.data.code; 
    router.push({ path: '/created', query: { code: questionCode } });
  })

    .catch(error => {
      console.error('Error creating question:', error.response.data);
      toast.add({ severity: 'error', summary: 'Error', detail: error.response.data.message });
    });
};
  </script>
  
  <style scoped>
  .input-lg {
    width: 400px; 
  }
  </style>
  
  