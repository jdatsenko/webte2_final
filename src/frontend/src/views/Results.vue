<script setup>
import { ref, onMounted, toRaw } from "vue";
import Chart from 'primevue/chart';
import Fieldset from "primevue/fieldset";
import { useQuestionStore } from '../stores/question.store';
import { GetAllAnswers } from "../api";

const currentPath = window.location.pathname;
const parts = currentPath.split("/");
const url = parts[parts.length - 1];
const { state, getQuestion } = useQuestionStore();

const chartData = ref();
const chartOptions = ref();
const showChoiceChart = ref(false);
const showOpenChart = ref(false);


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
    console.log(rawObjectOrArray.question.type);
    const questionType = rawObjectOrArray.question.type;
    console.log(questionType);
    if(questionType === "choice"){
        showChoiceChart.value = true;
        showOpenChart.value = false;
    }
    else if(questionType === "open"){
        showChoiceChart.value = false;
        showOpenChart.value = true;

    }
    const response = await GetAllAnswers.get(url);
    const labels = [];
    const data = [];
    state.answers.forEach(element => {
        labels.push(element.answer);
    });
    response.data.responses.forEach(item => {
        data.push(item.count);
    });

    chartData.value = setChartData(labels, data, response.data.responses);
    chartOptions.value = setChartOptions();
});

</script>

<template>
    <div class="flex justify-content-center">
        <Fieldset :legend="state.question.subject" style="width: 50%">
            <h1>{{ state.question.question }}</h1>
            <div v-if="showChoiceChart" class="flex justify-content-center">
                <div class="flex justify-content-center">
                    <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full md:w-35rem" />
                </div>
            </div>
            <div v-if="showOpenChart" class="flex justify-content-center">
                <div class="flex justify-content-center">
                    <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full md:w-35rem" />
                </div>
            </div>
            <div v-else class="flex justify-content-center">
                <div class="flex justify-content-center">
                    <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full md:w-35rem" />
                </div>
            </div>
        </Fieldset>
    </div>

</template>
