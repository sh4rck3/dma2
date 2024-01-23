<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Content from './Partials/Content.vue';
import { computed, inject, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const toast = inject('$toast')
const swal = inject('$swal')
const page = usePage()
const pageRole = computed(() => page.props.user.roles)

onMounted(() => {
   
    console.log('mounted')
    Echo.channel('public').listen('.Hello', (e) => {
        console.log('goit')
        console.log(e);
    });
})
</script>

<template>
    <AppLayout title="Usuários">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Controle de Iniciais
                    </h2>
                </div>
                <div>
                    <a
                    href="/inactiveusers">
                        <button class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded align-middle">
                            Listar pendentes
                        </button>
                    </a>
                    <a
                    href="/legalticket">
                        <button class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded align-middle">
                            Novo pedido de inicial
                        </button>
                    </a>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Content />
                </div>
            </div>
        </div>
    </AppLayout>
</template>