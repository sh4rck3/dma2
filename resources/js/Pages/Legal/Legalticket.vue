<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Content from './Partials/LegalTicket.vue';
import { computed, inject } from 'vue';
import { usePage } from '@inertiajs/vue3';

const toast = inject('$toast')
const swal = inject('$swal')
const page = usePage()
const pageRole = computed(() => page.props.user.roles)

const updatingList = async () =>{
    //console.log('updating list')
    // toast.success('Atualizando lista de usuários, aguarde alguns instantes...', {position: 'top-right'})
    swal({
        title: 'Atualizando contatos!',
        html: 'Aguarde alguns instantes...',
        timer: 20000,
        timerProgressBar: true,
        didOpen: () => {
            swal.showLoading()
        }
        })
    axios.get('/api/usersupdate')
    .then(response => {
        console.log(response.data),
        swal({
            title: response.data.title,
            text: response.data.message,
            icon: response.data.icon
                })
    })
    .catch(error => {
        swal({
                    icon: 'error',
                    title: 'Lista nao foi atualizada!'
                })
    })
}
</script>

<template>
    <AppLayout title="Usuários">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Novo pedido de inicial
                    </h2>
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