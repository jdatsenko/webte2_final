<script setup>
import Button from 'primevue/button'; 
import { router } from "../router";
import InputOtp from 'primevue/inputotp';
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';

const code = ref('');
const toast = useToast();
const handleJoin = () => {
    console.log('Code:', code.value);
    if (code.value.length !== 5) {
        toast.add({ severity: 'error', summary: 'Invalid Code', detail: 'Code must be 5 characters long' });
        return;
    } else if (/^[a-z0-9]+$/i.test(code.value) === false) {
        toast.add({ severity: 'error', summary: 'Invalid Code', detail: 'Code must contain only letters and numbers' });
        return;
    }
    router.push(`/question/${code.value}`);
};
</script>

<template>
    <div class="flex flex-column gap-2 align-items-center">
        <InputOtp v-model="code" :length="5" />
        <Button label="Join" @click="handleJoin" />
    </div>
</template>