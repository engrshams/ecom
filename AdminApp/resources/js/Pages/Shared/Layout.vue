<script setup>
    import Sidebar from './Sidebar.vue'
</script>
<template>
    <div class="h-screen"> 
        <!-- Sidebar -->
        <Sidebar />

        <!-- Main Content -->
        <slot />
    </div>
</template>
<style scoped>
</style>