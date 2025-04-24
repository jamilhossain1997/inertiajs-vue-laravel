<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Products</h1>
        <Link href="/products/create" class="bg-green-600 text-white px-4 py-2 mb-4 inline-block rounded">+ New Product
        </Link>
        <button @click="logout">Logout</button>

        <table class="table-auto w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Name</th>
                    <th class="p-2 border">SKU</th>
                    <th class="p-2 border">Price</th>
                    <th class="p-2 border">Stock</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
                    <td class="p-2 border">{{ product.name }}</td>
                    <td class="p-2 border">{{ product.sku }}</td>
                    <td class="p-2 border">${{ product.price }}</td>
                    <td class="p-2 border">{{ product.stock }}</td>
                    <td class="p-2 border">
                        <Link :href="`/products/${product.id}/edit`" class="text-blue-500 mr-2">Edit</Link>
                        <button @click="deleteProduct(product.id)" class="text-red-600">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script setup>
import { router, Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'

defineProps(['products'])

function deleteProduct(id) {
    if (confirm('Are you sure?')) {
        router.delete(`/products/${id}`)
    }
}

const logout = () => {
  Inertia.post('/logout')
}
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

th,
td {
    padding: 0.75rem;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f3f4f6;
}

tr:hover {
    background-color: #f9fafb;
}

.bg-green-600 {
    background-color: #16a34a;
}

.bg-green-600:hover {
    background-color: #15803d;
}

.text-white {
    color: white;
}

.text-blue-500:hover {
    text-decoration: underline;
}

.text-red-600 {
    color: #dc2626;
}

.text-red-600:hover {
    color: #b91c1c;
}

button {
    background: none;
    border: none;
    cursor: pointer;
}
</style>
