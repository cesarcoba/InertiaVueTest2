<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    deliveries: { type: Object }
});
const form = useForm({
    id: ''
});

const deleteDelivery = (id, name) => {
    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Are you sure delete ' + name + ' ?',
        icon: 'question', showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Yes, delete',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('deliveries.destroy', id));
        }
    });
}

</script>

<template>
    <AppLayout title="Deliveries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Deliveries
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('deliveries.create')"
                        :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                    <i class="fa-solid fa-plus-circle"></i> Add
                    </Link>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Delivery</th>
                            <th class="px-4 py-4">Observation</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody v-for="dep, i in deliveries" :key="dep.id">
                        <td class="border border-gray-400 px-4 py-4">{{ i + 1 }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ dep.name }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ dep.observation }}</td>
                        <td class="border border-gray-400 px-4 py-4">
                            <Link :href="route('deliveries.edit', dep.id)"
                                :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                            <i class="fa-solid fa-edit"></i>
                            </Link>
                        </td>
                        <td class="border border-gray-400 px-4 py-4">
                            <DangerButton @click="$event => deleteDelivery(dep.id, dep.name)">
                                <i class="fa-solid fa-trash"></i>
                            </DangerButton>
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
