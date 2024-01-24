<script setup>
import Icon from '@/Icons/Icon.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';

import { onMounted, ref, inject, computed, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3'
import useLegal from '@/composables/legal.js'

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
const { legals, getLegals } = useLegal()

onMounted(() => {
    getLegals()
   
    console.log('mounted')
    Echo.channel('newlegal').listen('.SendMessage', (e) => {
        console.log('goit')
        console.log(e);
        getLegals()
    });
   
})

function changePage(page) {
    getLegals(page)
}

watch(search_global, (current, previous) => {
    getLegals(
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
                       Pedido de iniciais
                    </h1>
                    
            </div>
            <div class="flex justify-end">
                <div class="font-medium text-gray-900 dark:text-white">
                    <div class="flex">
                        Legenda:
                    </div>
                    <div class="flex">
                        <Icon name="evelope" class="block h-5 w-5 text-red-500" /> - Novo
                    </div>
                    <div class="flex">
                        <Icon name="open" class="block h-5 w-5 text-yellow-500" /> - Em andamento
                    </div>
                    <div class="flex">
                        <Icon name="checkcircle" class="block h-5 w-5 text-green-500" /> - Concluído
                    </div>
                </div>
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
                        <fwb-table-head-cell>Título</fwb-table-head-cell>
                        <fwb-table-head-cell>Status</fwb-table-head-cell>
                        <fwb-table-head-cell>Descrição</fwb-table-head-cell>
                        <fwb-table-head-cell>Arquivo</fwb-table-head-cell>
                        <fwb-table-head-cell>
                            <span class="sr-only">Editar</span>
                        </fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-if="legals.data && legals.data.length > 0"
                            v-for="post in legals.data" :key="post.id">
                            
                            <fwb-table-cell>{{ post.id }}</fwb-table-cell>
                            <fwb-table-cell>{{ post.username }}</fwb-table-cell>
                            <fwb-table-cell>{{ post.title }}</fwb-table-cell>
                            <fwb-table-cell>
                                <div v-if="post.status == 1">
                                    <Icon name="evelope" class="block h-5 w-5 text-red-500" />
                                </div>
                                <div v-else-if="post.status == 2">
                                    <Icon name="open" class="block h-5 w-5 text-yellow-500" />
                                </div>
                                <div v-else-if="post.status == 3">
                                    <Icon name="checkcircle" class="block h-5 w-5 text-green-500" />
                                </div>
                            </fwb-table-cell>
                            <fwb-table-cell>{{ post.description }}</fwb-table-cell>
                            <fwb-table-cell>
                                <a :href="post.path">
                                    {{ post.original_name }}
                                </a>
                                
                            </fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-a :href="`/users/${post.id}`">
                                    <Icon name="edit" class="block h-5 w-5" />
                                </fwb-a>
                            </fwb-table-cell>
                        </fwb-table-row>
                        <fwb-table-row
                            v-else
                            >
                            <fwb-table-cell colspan="6" class="text-center py-4">
                                Nenhum registro encontrado.
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
                <div className="flex overflow-x-auto sm:justify-center mt-4">
                    <fwb-pagination
                        v-if="legals.data && legals.data.length > 0"
                        @click.prevent="changePage(legals.meta.current_page)"  
                        v-model="legals.meta.current_page" 
                        :total-pages="legals.meta.last_page"
                        >
                    </fwb-pagination>
                </div>
            </div>
            
        </div>
        <Footer />
    </div>
</template>
