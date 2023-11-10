<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { inject, onMounted } from 'vue';

const swal = inject('$swal');
onMounted(() => {
    swal({
        title: 'Bem Vindo!',
        html: 'Teremos quadro de avisos aqui no sistema, fique por dentro de tudo que acontece na empresa.',
        timer: 5000,
        timerProgressBar: true,
        didOpen: () => {
            swal.showLoading();
        },
    });
});
</script>

<template>
    <AppLayout title="Painel">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Painel
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
