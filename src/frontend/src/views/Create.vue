<template>
    <div class="flex flex-column align-items-center justify-content-center">
      <h1>Create Question</h1>
      <form @submit.prevent="handleSubmit" class="flex flex-column mx-auto grid justify-content-center">
        <div class="flex flex-column align-items-center justify-content-center">
          <div class="field mb-2">
            <label for="question" class="block">Question:</label>
            <InputText id="question" type="text" v-model="questionText" class="input-lg"/>
          </div>
  
          <div v-for="(answer, index) in answers" :key="index" class="field mb-2">
            <div class="flex align-items-center">
              <Checkbox v-model="checked[index]" :binary="true" class="mr-2 mb-1"/>
              <label :for="'answer' + index" class="block">Answer {{ index + 1 }}:</label>
            </div>
            <InputText :id="'answer' + index" type="text" v-model="answers[index]" class="input-lg"/>
          </div>
          
          <div class="flex align-items-center justify-content-center">
            <Button type="submit" label="Submit"/>
          </div>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useToast } from 'primevue/usetoast';
  import InputText from 'primevue/inputtext';
  import Checkbox from 'primevue/checkbox';
  import Button from 'primevue/button';
  import { router } from "../router";
  const toast = useToast();
  
  const questionText = ref('');
  const answers = ref(['', '', '', '']);
  const checked = ref([false, false, false, false]);
  
  const handleSubmit = () => {
    if (questionText.value.trim() === '' || answers.value.some(answer => answer.trim() === '')) {
      toast.add({ severity: 'error', summary: 'Invalid Input', detail: 'Fill all the fields' });
      return;
    }
    if (!checked.value.includes(true)) {
    toast.add({ severity: 'error', summary: 'Invalid Input', detail: 'You need to select one right answer' });
    return;
  }
    
    const question = {
      text: questionText.value,
      answers: answers.value,
      checked: checked.value
    };
    console.log('Submitted Question:', question);
    router.push('/created')
  };
  </script>
  
  <style scoped>
  .input-lg {
    width: 400px; 
  }
  </style>
  
  