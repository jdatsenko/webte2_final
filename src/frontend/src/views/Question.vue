<script setup>
import { onMounted } from 'vue';
import { useQuestionStore } from '../stores/question.store';

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
        <h1>Question not found</h1>
    </div>
    <div v-else>
        <h1>{{ state.question.question }}</h1>
        <p>{{ state.question.subject }}</p>
    </div>
</template>