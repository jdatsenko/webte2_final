<template>
    <div class="flex justify-content-center flex-wrap">
    <h1 class="p-text-bold p-text-center">{{ t('Register.title') }}</h1>
  </div>
    <form @submit.prevent="register">
     
    <div class="card flex mb-3 justify-content-center">
        <div class="flex flex-column gap-2">
            <label for="email">Email</label>
            <InputText id="email" v-model="email"  />
        </div>
    </div>
    <div class="card flex my-3 justify-content-center">
        <div class="flex flex-column gap-2">
            <label for="value">Password</label>
            <Password v-model="password" :feedback="false" autocomplete="off" />
        </div>
    </div>
    <div class="card flex my-3 justify-content-center">
        <div class="flex flex-column gap-2">
            <label for="value">Repeat Password</label>
            <Password v-model="repeatPassword" :feedback="false" autocomplete="off" />
        </div>
    </div>
      
    <div class="card flex justify-content-center">
        <Button label="Submit" />
    </div>
  </form>

    <div class="flex mt-4 justify-content-center">
        <div class="flex align-items-center">
            <span>Already have an account?</span>
        </div>
        <div class="ml-2"> 
            <Button label="Login" outlined @click="router.push('/login')" />
        </div>
    </div>


  </template>

  <script setup>
        import { ref } from 'vue';
        import { t } from "@/i18n";
  
        import Button from 'primevue/button';
        import InputText from 'primevue/inputtext';
        import Password from 'primevue/password';
        import { router } from "../router";

    const email = ref('');
    const password = ref('');
    const repeatPassword = ref('');

    const register = () => {
    };
  </script>
  