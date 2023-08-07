<script setup>
import { ref } from 'vue';




</script>
<template>
    <div class="h-80 flex flex-row">
        <div class="basis-1/3 grid grid-cols-2 gap-4 border-2 border-slate-600 justify-items-end">
            <div>grid1</div>
            <div class="justify-end">grid2</div>
            <div>grid3</div>
            <div>grid4</div>
        </div>
        <div class="basis-1/3 border-2 border-rose-500 rounded-lg ">Drag and Drop</div>
        <div class="basis-1/3 flex flex-col gap-2 border-2 border-gray-500 m-1 h-full justify-start">
                <div class="flex flex-row justify-between border-2 border-b-red-600 ">
                    <div class="">flex1_1</div>
                    <div class="">flex1_2</div>
                </div>
                <div class="flex flex-row justify-end border-2 border-red-300">
                    <div class="">flex2_1</div>
                    <div class="">flex2_2</div>
                </div>
                <div class="flex flex-row justify-center border-double border-4 border-sky-500">
                    <div class="">flex3_1</div>
                    <div class="">flex3_2</div>
                </div>
                <div class="flex flex-row border-4 border-sky-500 h-full justify-between items-end">
                        <div class="">flex4_1</div>
                        <div class="">flex4_2</div>
                </div>
        </div>
    </div>
</template>
