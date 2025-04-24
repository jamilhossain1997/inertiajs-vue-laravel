<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Products</h1>
      <Link href="/products/create" class="bg-green-600 text-white px-4 py-2">+ New Product</Link>
  
      <div v-for="product in products" :key="product.id" class="mt-4 border p-4">
        <h2 class="text-lg font-semibold">{{ product.name }}</h2>
        <p>SKU: {{ product.sku }}</p>
        <p>Price: ${{ product.price }}</p>
        <p>Stock: {{ product.stock }}</p>
        <Link :href="`/products/${product.id}/edit`" class="text-blue-500 mr-2">Edit</Link>
        <button @click="deleteProduct(product.id)" class="text-red-600">Delete</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { router, Link } from '@inertiajs/vue3'
  defineProps(['products'])
  
  function deleteProduct(id) {
    if (confirm('Are you sure?')) {
      router.delete(`/products/${id}`)
    }
  }
  </script>
  