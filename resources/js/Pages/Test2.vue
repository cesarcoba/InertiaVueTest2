<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import Columna from '@/Pruebas/Columna.vue';
import Contadorsetup from '@/Pruebas/Contadorsetup.vue';
//import FileUpload from '@/Pruebas/AddFile.vue';
import AddArchivo from '@/Pruebas/AddArchivo.vue';
import UploadFileFull from '@/Pruebas/UploadFileFull.vue';


</script>


<template>
    <AppLayout title="Test2">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Test2
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="flex border-4 border-sky-200 h-40">
                        <h1>Drag and Drop</h1>
                        <UploadFileFull></UploadFileFull>
                    </div>
                    <div class="flex border-4 border-sky-200 h-40">
                            <h1>AddArchivo</h1>

                        </div>
                    <div>
                        <h3>En columnas</h3>
                        <Columna></Columna>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
