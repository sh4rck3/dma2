<script setup>
import AppLayout from '@/Layouts/AppLayoutLanding.vue';
import Birthday from '@/Components/Landings/Birthday.vue';

</script>

<template>
    <AppLayout title="Aniversariantes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Aniversariantes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Birthday />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
