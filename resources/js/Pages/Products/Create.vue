<template>
    <div>
        <h1 class="text-xl font-bold mb-4">Add Product</h1>
        <form @submit.prevent="submit">
            <input v-model="form.name" placeholder="Name"  /><br/><br/>
            <input v-model="form.sku" placeholder="SKU"  /><br/><br/>
            <input v-model="form.price" type="number" step="0.01" placeholder="Price"  /><br/><br/>
            <input v-model="form.stock" type="number" placeholder="Stock"  /><br/><br/>
            <button type="submit" >Save</button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    sku: '',
    price: '',
    stock: ''
})

function submit() {
    form.post('/products')
}
</script>

<style scoped>
div {
    max-width: 400px;
    margin: 0 auto;
    padding: 1.5rem;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

input {
    width: 100%;
    padding: 0.5rem;
    border-radius: 4px;
    border: 1px solid #ccc;
    transition: border-color 0.3s;
}

input:focus {
    border-color: #3b82f6;
    outline: none;
}

button {
    width: 100%;
    height:38px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #2563eb;
}
</style>