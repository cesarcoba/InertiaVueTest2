<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import DataTable from 'datatables.net-vue3';
import 'datatables.net-dt/css/jquery.dataTables.css';
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-responsive-dt';

import 'datatables.net-responsive-dt/css/responsive.dataTables.min.css';
import JsZip from 'jszip';
import pdfmake from "pdfmake/build/pdfmake";
import * as pdffonts from "pdfmake/build/vfs_fonts";

pdfmake.vfs = pdffonts.pdfMake ? pdffonts.pdfMake.vfs : pdfmake.vfc;
window.JSZip = JsZip;
DataTable.use(ButtonsHtml5);

const props = defineProps({
    employees: { type: Object },
    departments: { type: Object }
});

const columns1 = ref([]);
const columns2 = ref([]);
const buttons1 = ref([]);
const buttons2 = ref([]);
const report = ref([]);
const types = ref([{'id':'1','name':'Employees'}, { 'id': '2', 'name': 'Departments' }]);

columns1.value = [{data:null,render:function(data,type,row,meta)
    {return (meta.row + 1)}},
    {data:'name'},
    { data: 'email' },
    { data: 'phone' },
    { data: 'department' },
]
columns2.value = [{
    data: null, render: function (data, type, row, meta) { return (meta.row + 1) }
},
{ data: 'name' }
]
buttons1.value = [
    {
        title:'Employees',
        extend:'excelHtml5',
        text:'<i class="fa-solid fa-file-excel"></i> Excel',
        className:'inline-flex items-center px-4 py-2 bg-green-800 dark:bg-green-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-green-800 uppercase tracking-widest hover:bg-green-700 dark:hover:bg-white focus:bg-green-700 dark:focus:bg-white active:bg-green-900 dark:active:bg-green-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-green-800 transition ease-in-out duration-150'
    },
    {
        title: 'Employees',
        extend: 'pdfHtml5',
        text: '<i class="fa-solid fa-file-pdf"></i> PDF',
        className: 'inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
    },
    {
        title: 'Employees',
        extend: 'print',
        text: '<i class="fa-solid fa-print"></i> PRINT',
        className: 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
    },
    {
        title: 'Employees',
        extend: 'copy',
        text: '<i class="fa-solid fa-copy"></i> COPY',
        className: 'inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs  dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
    }
]
buttons2.value = [
    {
        title: 'Departments',
        extend: 'excelHtml5',
        text: '<i class="fa-solid fa-file-excel"></i> Excel',
        className: 'inline-flex items-center px-4 py-2 bg-green-800 dark:bg-green-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-green-800 uppercase tracking-widest hover:bg-green-700 dark:hover:bg-white focus:bg-green-700 dark:focus:bg-white active:bg-green-900 dark:active:bg-green-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-green-800 transition ease-in-out duration-150'
    },
    {
        title: 'Departments',
        extend: 'pdfHtml5',
        text: '<i class="fa-solid fa-file-pdf"></i> PDF',
        className: 'inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
    },
    {
        title: 'Departments',
        extend: 'print',
        text: '<i class="fa-solid fa-print"></i> PRINT',
        className: 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
    },
    {
        title: 'Departments',
        extend: 'copy',
        text: '<i class="fa-solid fa-copy"></i> COPY',
        className: 'inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-200 border border-gray-800 rounded-md font-semibold text-xs  dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
    }
]

</script>

<template>
    <AppLayout title="Reports">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Reports
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="px-6 py-6 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <h2>si funciona</h2>
                    <InputLabel for="rep" Value="Report:"></InputLabel>
                    <SelectInput id="rep" class="mt-1 block w-3/4"
                    v-model="report" :options="types"></SelectInput>
                </div>
                <div v-if ="report =='1'" class="px-6 py-6 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <DataTable
                        :data="employees"
                        :columns="columns1"
                        class="w-full border border-gray-400"
                        :options = "{responsive:true, autowidth:false,dom:'Bfrtip',buttons:buttons1}"
                    >
                    <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2">#</th>
                                <th class="px-2 py-2">Name</th>
                                <th class="px-2 py-2">Email</th>
                                <th class="px-2 py-2">Phone</th>
                                <th class="px-2 py-2">Department</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
                <div v-else class="px-6 py-6 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <DataTable
                            :data="departments"
                            :columns="columns2"
                            class="w-full border border-gray-400"
                            :options = "{ responsive: true, autowidth: false, dom: 'Bfrtip', buttons: buttons2 }"
                        >
                        <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-2">#</th>
                                    <th class="px-2 py-2">Name</th>
                                </tr>
                            </thead>
                        </DataTable>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
