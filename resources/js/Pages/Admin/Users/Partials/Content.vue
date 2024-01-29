<script setup>
import Icon from '@/Icons/Icon.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';

import { onMounted, ref, inject, computed, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3'
import useUsers from '@/composables/users'

import {
  FwbA,
  FwbTable,
  FwbTableBody,
  FwbTableCell,
  FwbTableHead,
  FwbTableHeadCell,
  FwbTableRow,
  FwbPagination,
} from 'flowbite-vue';


const page = usePage()
const pagePermission = computed(() => page.props.user.permissions)
const swal = inject('$swal')
const pageRole = computed(() => page.props.user.roles)


function showAlert() {
    swal({
        icon: 'success',
        title: 'Category saved successfully'
    })
}

const search_global = ref('')
const { users, getUsers, deleteUser } = useUsers()

onMounted(() => {
    getUsers()
    console.log(pagePermission.value)
})

function changePage(page) {
    getUsers(page)
}

watch(search_global, (current, previous) => {
    getUsers(
        1,
        current
    )
})

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                
                    <Icon name="laravel" class="h-10 w-10 mx-2" />
                
                
                    <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                       Usuarios
                    </h1>
            </div>
            <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                <div class="mb-4">
                    <input v-model="search_global" type="text" placeholder="Buscar..."
                            class="form-control w-25">
                </div>
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>ID</fwb-table-head-cell>
                        <fwb-table-head-cell>Nome</fwb-table-head-cell>
                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                        <fwb-table-head-cell>Grupo</fwb-table-head-cell>
                        <fwb-table-head-cell>
                            <span class="sr-only">Editar</span>
                        </fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-if="users.data && users.data.length > 0"
                            v-for="post in users.data" :key="post.id">
                            
                            <fwb-table-cell>{{ post.id }}</fwb-table-cell>
                            <fwb-table-cell>{{ post.name }}</fwb-table-cell>
                            <fwb-table-cell>{{ post.email }}</fwb-table-cell>
                            <fwb-table-cell>{{ post.roles[0].name }}</fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-a :href="`https://glpi.dunice.com.br/front/user.form.php?id=${post.id}`" target="_blank">
                                    <Icon name="edit" class="block h-5 w-5" />
                                </fwb-a>
                                <fwb-a href="#" 
                                        v-if="pagePermission.includes('delete articles')" 
                                        @click.prevent="deleteUser(post.id)"
                                       >
                                        <Icon name="trash" class="block h-5 w-5 text-gray-500" />
                                </fwb-a>
                            </fwb-table-cell>
                        </fwb-table-row>
                        <fwb-table-row
                            v-else
                            >
                            <fwb-table-cell colspan="6" class="text-center py-4">
                                Nenhum Usuário encontrado.
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
                <div className="flex overflow-x-auto sm:justify-center mt-4">
                    <fwb-pagination
                        v-if="users.data && users.data.length > 0"
                        @click.prevent="changePage(users.meta.current_page)"  
                        v-model="users.meta.current_page" 
                        :total-pages="users.meta.last_page"
                        >
                    </fwb-pagination>
                </div>
            </div>
            
        </div>
        <Footer />
    </div>
</template>
