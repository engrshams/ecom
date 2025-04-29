<script setup>
import { computed, onMounted } from 'vue';
import Layout from '../Shared/Layout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();
const flash = computed(() => usePage().props.flash);

    const props = defineProps({
        settings: Object,
    });

    const form = useForm({
        'store_id': '',  'store_password': '',  'api_endpoint': '',  'currency': '',
        'success_url': '',     'fail_url': '',   'cancel_url': '',   'ipn_url': '',  
        'init_url': ''    });
        
    onMounted(() => {
        //console.log( props.settings);
        if (props.settings) {        
        form.store_id = props.settings.store_id;
        form.store_password = props.settings.store_password;
        form.api_endpoint = props.settings.api_endpoint;
        form.currency = props.settings.currency;
        form.success_url = props.settings.success_url;
        form.fail_url = props.settings.fail_url;
        form.cancel_url = props.settings.cancel_url;
        form.ipn_url = props.settings.ipn_url;
        form.init_url = props.settings.init_url;
        }
    });

    const submitForm = () => {
        form.put('/settings/${props.settings.id}',{
            onSuccess: () => {
                //alert('Settings saved successfully!');
                // toast.success('Settings saved successfully!');
                flash.value.success && toast.success(flash.value.success);
                flash.value.error && toast.error(flash.value.error);
            },
        });
    };
</script>
<template>
    <Layout>
        <div class="flex justify-center">
            <!-- Main Content -->
            <main class="ml-64 p-8">
                <h3 class="text-lg font-bold mb-4">SSLCommerz Payment Gateway Configuration</h3>
                <form class="bg-white shadow-md rounded-lg p-6" @submit.prevent="submitForm">                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">                        
                        <div class="mb-4">
                            <label for="store-id" class="block text-gray-700 font-bold mb-2">Store ID</label>
                            <input type="text" id="store-id" class="w-full p-2 border rounded-md"
                                placeholder="Enter Store ID" required v-model="form.store_id">
                        </div>
                        <div class="mb-4">
                            <label for="store-password" class="block text-gray-700 font-bold mb-2">Store
                                Password</label>
                            <input type="text" id="store-password" class="w-full p-2 border rounded-md"
                                placeholder="Enter Store Password" required v-model="form.store_password">
                        </div>
                        <div class="mb-4">
                            <label for="currency" class="block text-gray-700 font-bold mb-2">currency</label>
                            <input type="text" id="currency" class="w-full p-2 border rounded-md"
                                placeholder="Enter currency" required v-model="form.currency">
                        </div>
                        <div class="mb-4">
                            <label for="success-url" class="block text-gray-700 font-bold mb-2">Success URL</label>
                            <input type="text" id="success-url" class="w-full p-2 border rounded-md" required
                                v-model="form.success_url">
                        </div>
                        <div class="mb-4">
                            <label for="fail-url" class="block text-gray-700 font-bold mb-2">Fail URL</label>
                            <input type="text" id="fail-url" class="w-full p-2 border rounded-md" required
                                v-model="form.fail_url">
                        </div>
                        <div class="mb-4">
                            <label for="cancel-url" class="block text-gray-700 font-bold mb-2">Cancel URL</label>
                            <input type="text" id="cancel-url" class="w-full p-2 border rounded-md" required
                                v-model="form.cancel_url">
                        </div>
                        <div class="mb-4">
                            <label for="ipn-url" class="block text-gray-700 font-bold mb-2">IPN URL</label>
                            <input type="text" id="ipn-url" class="w-full p-2 border rounded-md" required
                                v-model="form.ipn_url">
                        </div>
                        <div class="mb-4">
                            <label for="init-url" class="block text-gray-700 font-bold mb-2">INIT URL</label>
                            <input type="text" id="init-url" class="w-full p-2 border rounded-md" required
                                v-model="form.init_url">
                        </div>                        
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Settings</button>
                </form>
            </main>
        </div>
    </Layout>
</template>
<style scoped>
</style>