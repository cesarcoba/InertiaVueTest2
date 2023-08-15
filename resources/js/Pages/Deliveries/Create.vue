<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    observation: ''
});
</script>

<template>
    <AppLayout title="Deliveries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Delivery
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="$event => form.post(route('deliveries.store'))" class="mt-6 space-y-6 max-w-xl">
                        <InputLabel for="name" value="Delivery"></InputLabel>
                        <TextInput id="name" v-model="form.name" autofocus required type="text" class="mt-1 block w-full">
                        </TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>
                        <InputLabel for="observation" value="Observation"></InputLabel>
                            <TextInput id="observation" v-model="form.observation"  required type="text" class="mt-1 block w-full">
                            </TextInput>
                            <InputError :message="form.errors.observation" class="mt-2"></InputError>
                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i>Save
                        </PrimaryButton>
                    </form>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
