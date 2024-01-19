<script setup>
import Icon from '@/Icons/Icon.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';

import { onMounted, ref, inject, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import useSendsms from '@/composables/sendsms';
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



const search_global = ref('')
const { smss, getSmss } = useSendsms()

onMounted(() => {
    getSmss()
})


watch(search_global, (current, previous) => {
    getSmss(
        1,
        search_title.value,
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
                       Respostas do SMS
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
                        <fwb-table-head-cell>Telefone</fwb-table-head-cell>
                        <fwb-table-head-cell>Mensagem</fwb-table-head-cell>
                        <fwb-table-head-cell>Status</fwb-table-head-cell>
                        <fwb-table-head-cell>
                            <span class="sr-only">Resposta</span>
                        </fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-if="smss.data && smss.data.length > 0"
                            v-for="post in smss.data" :key="post.id">
                            
                            <fwb-table-cell>{{ post.id }}</fwb-table-cell>
                            <fwb-table-cell>{{ post.phone }}</fwb-table-cell>
                            <fwb-table-cell>{{ post.message }}</fwb-table-cell>
                            <fwb-table-cell>
                                <div v-if="post.status == 1">
                                    Na fila
                                </div>
                                <div v-else-if="post.status == 3">
                                    Enviado
                                </div>
                            </fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-a :href="`/users/${post.id}`">
                                    Resposta
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
                        v-if="smss.data && smss.data.length > 0"
                        @click.prevent="changePage(smss.meta.current_page)"  
                        v-model="smss.meta.current_page" 
                        :total-pages="smss.meta.last_page"
                        >
                    </fwb-pagination>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>
