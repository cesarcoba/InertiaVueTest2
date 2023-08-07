<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import Contador from '@/Pruebas/Contador.vue';
import Contadorsetup from '@/Pruebas/Contadorsetup.vue';
import Textos from '@/Pruebas/textos.vue';


</script>


<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <h1>hola user</h1>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
