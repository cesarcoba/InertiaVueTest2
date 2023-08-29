<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import { nextTick, ref, onMounted, onBeforeMount } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';

const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    people: { type: Object },
    deliveries: { type: Object }
});

onBeforeMount(() => {
    console.log('El componente se ha montado en el DOM');
    console.log(props);
})

const form = useForm({
    folio:'', name: '', paternal: '', maternal: '', delivery_id: '', municipality:'',amount:'',check_id:''
});
const onPageClick = (event) => {
    formPage.get(route('people.index', { page: event }));
}
const openModal = (op, folio, name, paternal, maternal, delivery, municipality, amount, check_id, person ) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = person;
    if (op == 1) {
        title.value = 'Create person';
    } else {
        title.value = 'Edit person';
        form.folio = folio;
        form.name = name;
        form.paternal = paternal;
        form.maternal = maternal;
        form.delivery_id = delivery;
        form.municipality = municipality;
        form.amount = amount;
        form.check_id = check_id;
    }
}
const closeModal = () => {
    modal.value = false;
    form.reset();
}
const save = () => {
    if (operation.value == 1) {
        form.post(route('people.store'), {
            onSuccess: () => { ok('Person created') }

        })
    }
    else {
        form.put(route('people.update', id.value), {
            onSuccess: () => { ok('Person updated') }

        })
    }
}
const ok = (msg) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: 'success' });
}
const formPage = useForm({});

const deletePerson = (id, name) => {
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
            form.delete(route('people.destroy', id), {
                onSuccess: () => {
                    ok('Person deleted')

                }
            });
        }
    });

}
</script>

<template>
    <AppLayout title="People">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                People
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event => openModal(1)">
                        <i class="fa-solid fa-plus-circle"></i> Add
                    </PrimaryButton>
                </div>
            </div>
            <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2">#</th>
                            <th class="px-2 py-2">Folio</th>
                            <th class="px-2 py-2">Name</th>
                            <th class="px-2 py-2">Paternal</th>
                            <th class="px-2 py-2">Maternal</th>
                            <th class="px-2 py-2">Delivery</th>
                            <th class="px-2 py-2">Municipality</th>
                            <th class="px-2 py-2">Amount</th>
                            <th class="px-2 py-2">Check</th>
                            <th class="px-2 py-2"></th>
                            <th class="px-2 py-2"></th>
                        </tr>
                    </thead>
                    <tbody v-for="per, i in people.data" :key="per.id">
                        <td class="border border-gray-400 px-2 py-2">{{ per.id }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.folio }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.name }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.paternal }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.maternal }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.delivery }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.municipality }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.amount }}</td>
                        <td class="border border-gray-400 px-2 py-2">{{ per.check_id }}</td>

                        <td class="border border-gray-400 px-2 py-2">
                            <WarningButton @click="$event => openModal(2, per.folio, per.name, per.paternal, per.maternal,
                                per.delivery_id, per.municipality, per.amount, per.check_id, per.id)">

                                <i class="fa-solid fa-edit"></i>
                            </WarningButton>

                        </td>
                        <td class="border border-gray-400 px-2 py-2">
                            <DangerButton @click="$event => deletePerson(per.id, per.name)">
                                <i class="fa-solid fa-trash"></i>
                            </DangerButton>
                        </td>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid v-screen place-items-center">
                <VueTailwindPagination :current="people.currentPage" :total="people.total" :per-page="people.perPage"
                    @page-changed="$event => onPageClick($event)">
                </VueTailwindPagination>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3">
                <InputLabel for="folio" value="Folio:"></InputLabel>
                <TextInput id="folio" v-model="form.folio" type="text" class="mt-1 block w-3/4" placeholder="Folio">
                </TextInput>
                <InputError :message="form.errors.folio" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="name" value="Name:"></InputLabel>
                <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
                    placeholder="Name"></TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="paternal" value="Paternal:"></InputLabel>
                <TextInput id="paternal" v-model="form.paternal" type="text" class="mt-1 block w-3/4"
                    placeholder="Paternal">
                </TextInput>
                <InputError :message="form.errors.paternal" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="maternal" value="Maternal:"></InputLabel>
                <TextInput id="maternal" v-model="form.maternal" type="text" class="mt-1 block w-3/4"
                    placeholder="Maternal">
                </TextInput>
                <InputError :message="form.errors.maternal" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="delivery_id" value="Delivery:"></InputLabel>
                <SelectInput id="delivery_id" :options="deliveries" v-model="form.delivery_id" type="number"
                    class="mt-1 block w-3/4" placeholder="Delivery"></SelectInput>
                <InputError :message="form.errors.delivery_id" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="municipality" value="Municipality:"></InputLabel>
                <TextInput id="municipality" v-model="form.municipality" type="text" class="mt-1 block w-3/4"
                    placeholder="Municipality">
                </TextInput>
                <InputError :message="form.errors.municipality" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="amount" value="Amount:"></InputLabel>
                <TextInput id="amount" v-model="form.amount" type="text" class="mt-1 block w-3/4"
                    placeholder="Amount">
                </TextInput>
                <InputError :message="form.errors.amount" class="mt-2"></InputError>
            </div>
            <div class="p-3">
                <InputLabel for="check_id" value="Check_id:"></InputLabel>
                <TextInput id="check_id" v-model="form.check_id" type="text" class="mt-1 block w-3/4"
                    placeholder="Check_id">
                </TextInput>
                <InputError :message="form.errors.check" class="mt-2"></InputError>
            </div>
            <div class="p-3 mt-6">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Save
                </PrimaryButton>
            </div>
            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disabled="form.processing" @click="closeModal">
                    Cancel
                </SecondaryButton>
            </div>
        </Modal>
    </AppLayout>
</template>
