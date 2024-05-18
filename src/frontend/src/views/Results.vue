<script setup>
import { ref, onMounted, toRaw, computed } from "vue";
import Chart from 'primevue/chart';
import Fieldset from "primevue/fieldset";
import { useQuestionStore } from '../stores/question.store';
import { GetAllAnswers } from "../api";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

const currentPath = window.location.pathname;
const parts = currentPath.split("/");
const url = parts[parts.length - 1];
const { state, getQuestion } = useQuestionStore();

const chartData = ref();
const chartOptions = ref();
const showChoiceChart = ref(false);
const showOpenChart = ref(false);
const container = ref(null);
const responses = ref([]);


const answers = ref({
    answer: []
})

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');

    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    color: textColor
                }
            }
        }
    };
};


const setChartData = (labels, data, responses) => {
    const documentStyle = getComputedStyle(document.body);

    const backgroundColors = [];
    const hoverBackgroundColors = [];

    responses.forEach(item => {
        if (item.isRight === 1) {
            backgroundColors.push(documentStyle.getPropertyValue('--green-500'));
            hoverBackgroundColors.push(documentStyle.getPropertyValue('--green-400'));
        } else {
            backgroundColors.push(documentStyle.getPropertyValue('--red-500'));
            hoverBackgroundColors.push(documentStyle.getPropertyValue('--red-400'));
        }
    });

    return {
        labels: labels,
        datasets: [
            {
                data: data,
                backgroundColor: backgroundColors,
                hoverBackgroundColor: hoverBackgroundColors
            }
        ]
    };
};

onMounted(async () => {
    await getQuestion(url);
    const rawObjectOrArray = toRaw(state);

    const questionType = rawObjectOrArray.question?.type;
    if (questionType === "choice") {
        showChoiceChart.value = true;
        showOpenChart.value = false;
    }
    else if (questionType === "answer") {
        showChoiceChart.value = false;
        showOpenChart.value = true;

    }
    const response = await GetAllAnswers.get(url);
    responses.value = response.data.responses;
    const labels = [];
    const data = [];

    state.answers.forEach(element => {
        labels.push(element.answer);
    });

    response.data.responses.forEach(item => {
        data.push(item.count);
        const answer = {
            text: item.text,
            count: item.count,
        };
        answers.value.answer.push(answer);

    });

    chartData.value = setChartData(labels, data, response.data.responses);
    chartOptions.value = setChartOptions();

    answers.value.answer.sort((a, b) => b.count - a.count);

    container.value = document.getElementById('container-id');

   
    populateWorldCloud();

});

function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}
function populateWorldCloud() {
    let j = answers.value.answer.length - 1;
    for (let i = 1; i < answers.value.answer.length + 1; i++) {
        const answer = answers.value.answer[j];
        answer.fontSize = 10 + 5 * i;
        j--;
    }
    shuffle(answers.value.answer);

}
const generateRandomColor = () => {
    const red = Math.floor(Math.random() * 256);
    const green = Math.floor(Math.random() * 256);
    const blue = Math.floor(Math.random() * 256);

    const colorCode = `#${red.toString(16)}${green.toString(16)}${blue.toString(16)}`;

    return colorCode;
};

function getRandomTextAlignment(index) {
    const alignments = ['left', 'center', 'right'];
    return alignments[Math.floor(Math.random() * alignments.length)];
}
</script>

<template>
    <v-list lines="one">
        <v-list-item v-for="n in 3" :key="n" :title="'Item ' + n"
            subtitle="Lorem ipsum dolor sit amet consectetur adipisicing elit"></v-list-item>
    </v-list>
    <div class="flex justify-content-center">
        <Fieldset :legend="state.question?.subject" style="width: 50%">
            <h1>{{ state.question?.question }}</h1>
            <div v-if="showChoiceChart && responses.length > 0" class="flex justify-content-center">
                <div class="flex justify-content-center">
                    <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full md:w-35rem" />
                </div>
            </div>
            <div v-if="showChoiceChart && responses.length == 0" class="flex justify-content-center">
                <p>No responses yet</p>
            </div>
            <div v-if="showOpenChart" class="flex justify-content-center">
                <Fieldset legend="Answers" style="width: 60%;">
                    <ul style="list-style-type: none;">
                        <li v-for="(answer, index) in answers.answer" :key="'answer-' + index">
                            {{ answer.count }} - {{ answer.text }}
                        </li>
                    </ul>

                </Fieldset>
            </div>
            <div v-else class="flex">
                <div style="display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 10px;">
                    <p v-for="(answer, index) in answers.answer" :key="'answer' + index" :style="{
                        fontSize: answer.fontSize + 'px',
                        color: generateRandomColor(),
                        textAlign: getRandomTextAlignment(index),
                        margin: 0,
                        padding: 10 + 'px',
                    }">{{ answer.text }}</p>
                </div>
            </div>
        </Fieldset>
    </div>

</template>
