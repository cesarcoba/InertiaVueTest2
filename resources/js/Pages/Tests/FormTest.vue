<script setup>
import BaseInput from '@/Base/BaseInput.vue/'

const saveValue = value => {
    alert(value)
}
</script>

<template>
    <h1>Ejemplo Componentes</h1>
    <BaseInput @update="saveValue" />
    <h2>-----------</h2>

    <form @submit.prevent="onSubmit()" class="contact-form">
        <h3>
          Contáctame
        </h3>
        <label for="name">Name:</label>
        <input id="name">

        <label for="msg">Mensaje:</label>
        <textarea id="msg"></textarea>

        <label for="location">Localidad:</label>
        <select id="location">
          <option disabled value="">Please select one</option>
          <option>Spain</option>
          <option>France</option>
        </select>

        <label for="accept">Aceptas:</label>
        <input id="accept" type="checkbox">

        <button class="button" type="submit">Enviar</button>
      </form>

</template>

<style scoped>
.contact-form {
    display: flex;
    flex-direction: column;
    width: 50%;
    border: 1px solid lightgrey;
    padding: 20px;
    border-radius: 8px;
}

.contact-form label {
    margin-top: 10px;
}

.contact-form .button {
    margin-top: 20px;
}
</style>
