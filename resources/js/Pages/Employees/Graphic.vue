<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import {ref} from 'vue';
import {Bar,Pie} from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const props = defineProps({
    data:{type:Object}
});

const departments = ref([]);
const employees = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);

const random = () =>{
    return Math.floor(Math.random()*256);
}
props.data.map((row)=>(
    departments.value.push(row.name),
    employees.value.push(row.count),
    //colors.value.push('#f87979')
    colors.value.push("rgb(" + random() + "," + random() + "," + random() + ")")
))

chartOptions.value={responsive:true}
chartData.value = {
    labels:departments.value,
    datasets:[
        {label:'Employees',data:employees.value,backgroundColor:colors}
    ]
}
</script>

<template>
    <AppLayout title="Graphic">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Graphic
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Bar :data="chartData" :options = "chartOptions"></Bar>
                </div>
            </div>
        </div>
        <div class="py-12">
                <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <Pie :data="chartData" :options = "chartOptions"></Pie>
                    </div>
                </div>
            </div>
    </AppLayout>
</template>
