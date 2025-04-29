<script setup>
    import { computed, onMounted, ref } from 'vue';
    import Layout from '../Shared/Layout.vue';
    import { useForm, usePage } from '@inertiajs/vue3';
    import { useToast } from 'vue-toastification';

    const toast = useToast();
    const flash = computed(() => usePage().props.flash);

    const props = defineProps({
        category: Object,
    });

    const CategoryImage= ref(null);

    const form = useForm({
        name: '',
        image: null,
        '_method': 'PUT',  // Required for PUT update method
    });

    const handleImage = (event) => {
        const file = event.target.files[0];
        if (file) {
            form.image = file;
            CategoryImage.value = URL.createObjectURL(file);
        }    
    };

    const submitForm = () => {
        form.post(`/categories/${props.category.id}`, {
            preserveScroll: true, //is helpful for keeping the scroll position after submit.
            onSuccess: () => {
                if (flash.value.success) toast.success(flash.value.success);
                if (flash.value.error) toast.error(flash.value.error);
            },
            onError: () => {
                toast.error('Failed to update Category. Please try again.');
            }
        })
    };

    onMounted(() => {
        if (props.category) {
            form.name = props.category.name;
            CategoryImage.value = props.category.image || null;
        }
    })
</script>
<template>           
    <Layout>
        <!-- Main Content -->
        <main class="ml-64 p-8">
            <h2 class="text-2xl font-bold mb-6">Edit Category</h2>
            <form @submit.prevent="submitForm" class="bg-white shadow-md rounded-lg p-6">
            <!-- Category Name -->
            <div class="mb-4">
                <label for="category-name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" id="category-name" class="w-full p-2 border rounded-md" placeholder="Enter Category name" required v-model="form.name">
            </div>
            <!-- Category Image -->
            <div class="mb-4">
                <label for="category-image" class="block text-gray-700 font-bold mb-2">Image</label>
                <input type="file" id="category-image" class="w-full p-2 border rounded-md" @change="handleImage" accept="image/*">  <!-- accept="image/*" restricts file chooser to images. -->
            </div>
            <!-- Preview Image -->
            <div v-if="CategoryImage" class="mb-4">
                <img :src="CategoryImage" alt="Category Image Preview" class="w-25 object-cover rounded-full mb-2"> <!-- object-cover on the image gives better scaling behavior. -->
            </div>
            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Category</button>
            </form>
        </main>
    </Layout>
</template>
<style scoped>
</style>