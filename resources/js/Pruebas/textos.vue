<script setup>
import {ref,reactive, toRefs} from 'vue';

let name = ref("la fiesta de pepito");
let capacity = ref(10);
const myData = reactive({
    nombre:"la rumba",
    capacidad: 10,
    invitados:["clara","pablo","carlos","sara"]
})

setTimeout(()=>{
    name.value = "otro nombre"
    myData.nombre = "LA FIESTA",
    myData.capacidad += 2,
    myData.invitados.push("Santiago")

},2000)

console.log(name)
console.log(myData);
console.log(myData.nombre);
</script>
<template>
    <div>
        <h5>Nombre del evento: {{ name }}</h5>
        <p>capacidad: {{ capacity }}</p>
        <hr>
        <h5>Nombre del evento: {{ myData.nombre }}</h5>
        <p>capacidad: {{ myData.capacidad }}</p>
        <ul>
            <li v-for="(invitado,i) in myData.invitados" :key="i">
                {{ invitado }}
            </li>
        </ul>
    </div>
</template>
