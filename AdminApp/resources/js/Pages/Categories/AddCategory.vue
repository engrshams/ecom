<script setup>
    import { computed, ref } from 'vue';
    import Layout from '../Shared/Layout.vue';
    import { useForm, usePage } from '@inertiajs/vue3';
    import { useToast } from 'vue-toastification';

    const toast = useToast();
    const flash = computed(() => usePage().props.flash);

    const CategoryImage= ref(null);

    const form = useForm({
        name: '',
        image: null,
    });

    const handleImage = (event) => {
        const file = event.target.files[0];
        if (file) {
            form.image = file;
            CategoryImage.value = URL.createObjectURL(file);
        }    
    };

    const submitForm = () => {
        form.post('/categories', {
            onSuccess: () => {
                flash.value.success && toast.success(flash.value.success);
                flash.value.error && toast.error(flash.value.error);
            },
            onError: () => {
                toast.error('Failed to add Category. Please try again.');
            }
        })
    };
</script>
<template>           
    <Layout>
        <!-- Main Content -->
        <main class="ml-64 p-8">
            <h2 class="text-2xl font-bold mb-6">Add Category</h2>
            <form class="bg-white shadow-md rounded-lg p-6" @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="category-name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" id="category-name" class="w-full p-2 border rounded-md" placeholder="Enter Category name" required v-model="form.name">
            </div>
            <div class="mb-4">
                <label for="category-image" class="block text-gray-700 font-bold mb-2">Image</label>
                <input type="file" id="category-image" class="w-full p-2 border rounded-md" v-on:change="handleImage">
            </div>
            <div class="mb-4">
                <img :src="CategoryImage" alt="Category Image" class="w-25 rounded-full mb-2"> 
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Category</button>
            </form>
        </main>
    </Layout>
</template>
<style scoped>
</style>