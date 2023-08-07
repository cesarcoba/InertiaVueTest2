<template>
    <main>
        <input type="file" ref="fileInput" @change="handleFileChange" />
        <button @click="doSomething">do something</button>
    </main>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const fileInput = ref<HTMLInputElement | null>(null);
const files = ref();

function handleFileChange() {
    files.value = fileInput.value?.files;
    console.log(files.value);
}

function doSomething() {
    const file = files.value[0];
    console.log(file);
    // do something here with the file
}
</script>
