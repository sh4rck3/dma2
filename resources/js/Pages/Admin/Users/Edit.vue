<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Content from './Partials/ContentEdit.vue';
import { defineProps } from 'vue';

const props = defineProps({
    userId: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <AppLayout title="Usuários">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Editar Usuário
                    </h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Content :userId="props.userId"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>