<script setup>
    import axios from 'axios';
    import { ref } from 'vue';

    const categories = ref([]);

    const getCategories = async () => {
        try {
            const response = await axios.get(route('api.categories'));
            categories.value = response.data;
        } catch (error) {
            console.error(error);
        }
    };

    getCategories();
</script>
<template>
    <div class="container mx-auto bg-white text-black p-4">
        <h1 class="text-2xl my-5">Product list API</h1>
        <a href="https://github.com/rounaknikhar/ProductListingTask" class="bg-black hover:bg-black/20 text-white px-4 py-1 rounded-md transition-colors" target="_blank" rel="noopener noreferrer">GitHub</a>
        <h2 class="text-md my-5">Accepts <i>application/json</i></h2>
        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border w-[200px] p-2"></th>
                    <th class="border text-left p-2">URL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2"><code>All products</code></td>
                    <td class="border p-2"><code>https://product-listing.rounak-nikhar.com/api/products</code></td>
                </tr>
                <tr>
                    <td class="border p-2" colspan="2"><code>Available parameter</code></td>
                </tr>
                <tr>
                    <td class="border p-2">
                        <span class="bg-neutral-200 p-1 rounded-md"><code>search</code></span>
                    </td>
                    <td class="border p-2">
                        string
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">
                        <span class="bg-neutral-200 p-1 rounded-md"><code>sort</code></span>
                    </td>
                    <td class="border p-2">
                        DESC | ASC
                    </td>
                </tr>
                <tr>
                    <td class="border p-2">
                        <span class="bg-neutral-200 p-1 rounded-md"><code>category</code></span>
                    </td>
                    <td class="border p-2">
                        <ul>
                            <li v-for="category in categories" class="p-1 border">{{ category.name }} (id: {{ category.id }})</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
