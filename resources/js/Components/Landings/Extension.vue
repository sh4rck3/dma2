<script setup>
import Icon from '@/Icons/Icon.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';

import { onMounted, ref, inject, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3'
import useUsers from '../../composables/userslanding'
import { FwbTab, FwbTabs } from 'flowbite-vue'
const activeTab = ref('Ramais')


const page = usePage()
const pagePermission = computed(() => page.props.user.permissions)
const swal = inject('$swal')
const apiusers = ref([])


function showAlert() {
    swal({
        icon: 'success',
        title: 'Category saved successfully'
    })
}

const search_id = ref('')
const search_title = ref('')
const search_global = ref('')
const orderColumn = ref('created_at')
const orderDirection = ref('desc')
const { users, getUsers, deleteUser } = useUsers()

onMounted(() => {
    getUsers()
})

const updateOrdering = (column) => {
    orderColumn.value = column;
    orderDirection.value = (orderDirection.value === 'asc') ? 'desc' : 'asc';
    getUsers(
        1,
        search_id.value,
        search_title.value,
        search_global.value,
        orderColumn.value,
        orderDirection.value
    );
}
watch(search_id, (current, previous) => {
    getUsers(
        1,
        current,
        search_title.value,
        search_global.value
    )
})
watch(search_title, (current, previous) => {
    getUsers(
        1,
        search_id.value,
        current,
        search_global.value
    )
})
watch(search_global, (current, previous) => {
    getUsers(
        1,
        search_id.value,
        search_title.value,
        current
    )
})
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <fwb-tabs v-model="activeTab" class="p-5">
                    <fwb-tab name="Ramais" title="Ramais">
                        <div class="w-screen px-4 py-5 flex justify-content align-items">
                                <Icon name="laravel" class="h-10 w-10 mx-2" />
                                <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                                FOX ->
                                </h1>
                                <small class="ml-3 text-2xl font-bold text-gray-900 dark:text-white mx-1">Ramais e informações atualizados</small>
                        </div>
                        <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                            <div class="card-body shadow-sm">
                                <div class="mb-4">
                                    <input v-model="search_global" type="text" placeholder="Buscar..."
                                        class="form-control w-25">
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                    
                                        <tr>
                                            <th class="px-6 py-3 text-start">
                                                <div class="flex flex-row"
                                                    @click="updateOrdering('id')">
                                                    <div class="font-medium text-uppercase"
                                                        :class="{ 'font-bold text-blue-600': orderColumn === 'id' }">
                                                        ID
                                                    </div>
                                                    <div class="select-none">
                                            <span :class="{
                                            'text-blue-600': orderDirection === 'asc' && orderColumn === 'id',
                                            'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'id',
                                            }">&uarr;</span>
                                                        <span :class="{
                                            'text-blue-600': orderDirection === 'desc' && orderColumn === 'id',
                                            'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'id',
                                            }">&darr;</span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left">
                                                <div class="flex flex-row"
                                                    @click="updateOrdering('title')">
                                                    <div class="font-medium text-uppercase"
                                                        :class="{ 'font-bold text-blue-600': orderColumn === 'title' }">
                                                        Nome
                                                    </div>
                                                    <div class="select-none">
                                            <span :class="{
                                            'text-blue-600': orderDirection === 'asc' && orderColumn === 'title',
                                            'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'title',
                                            }">&uarr;</span>
                                                        <span :class="{
                                            'text-blue-600': orderDirection === 'desc' && orderColumn === 'title',
                                            'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'title',
                                            }">&darr;</span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left">
                                                <div class="flex flex-row"
                                                    @click="updateOrdering('email')">
                                                    <div class="font-medium text-uppercase"
                                                        :class="{ 'font-bold text-blue-600': orderColumn === 'email' }">
                                                        Email
                                                    </div>
                                                    <div class="select-none">
                                            <span :class="{
                                            'text-blue-600': orderDirection === 'asc' && orderColumn === 'email',
                                            'hidden': orderDirection !== '' && orderDirection !== 'asc' && orderColumn === 'email',
                                            }">&uarr;</span>
                                                        <span :class="{
                                            'text-blue-600': orderDirection === 'desc' && orderColumn === 'email',
                                            'hidden': orderDirection !== '' && orderDirection !== 'desc' && orderColumn === 'email',
                                            }">&darr;</span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left">
                                                <div class="flex flex-row">
                                                    <div class="font-medium text-uppercase">
                                                        Ramal
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left">
                                                <div class="flex flex-row">
                                                    <div class="font-medium text-uppercase">
                                                        Setor
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left">
                                                <div class="flex flex-row">
                                                    <div class="font-medium text-uppercase">
                                                        Cargo
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="users.data && users.data.length > 0"
                                                v-for="post in users.data" :key="post.id">
                                                <td class="px-6 py-4 text-sm">
                                                    {{ post.id }}
                                                </td>
                                                <td class="px-6 py-4 text-sm">
                                                    {{ post.name }} 
                                                </td>
                                                <td class="px-6 py-4 text-sm">
                                                    {{ post.email }}
                                                </td>
                                                <td class="px-6 py-4 text-sm">
                                                    {{ post.extension }}
                                                </td>
                                                <td class="px-6 py-4 text-sm">
                                                    {{ post.sector }}
                                                </td>
                                                <td class="px-6 py-4 text-sm">
                                                    {{ post.jobtitle }}
                                                </td>
                                                
                                            </tr>
                                        
                                            <tr v-else>
                                                <td colspan="6" class="text-center py-4">
                                                    Nenhum usuário encontrado.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <Pagination :data="users" :limit="3"
                                            @pagination-change-page="page => getUsers(page, search_id, search_title, search_global, orderColumn, orderDirection)"
                                            class="mt-4"/>
                            </div>
                        </div>
                    </fwb-tab>
                    <fwb-tab name="Grupos" title="Grupos">

                    </fwb-tab>
            </fwb-tabs>
            
        </div>
        <Footer />
    </div>
</template>
