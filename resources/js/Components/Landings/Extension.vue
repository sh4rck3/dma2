<script setup>
import Icon from '@/Icons/Icon.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';

import { onMounted, ref, inject, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3'
import useUsers from '../../composables/userslanding'
import { FwbTab, FwbTabs, FwbA,
  FwbTable,
  FwbTableBody,
  FwbTableCell,
  FwbTableHead,
  FwbTableHeadCell,
  FwbTableRow,
  FwbCard } from 'flowbite-vue'
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
                    <fwb-tab name="Grupos de Ramais" title="Grupos de Ramais">
                        <div class="w-screen px-4 py-5 flex justify-content align-items">
                                <Icon name="laravel" class="h-10 w-10 mx-2" />
                                <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                                FOX ->
                                </h1>
                                <small class="ml-3 text-2xl font-bold text-gray-900 dark:text-white mx-1">Grupo de Ramais</small>
                        </div>
                        <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                            <div class="card-body shadow-sm">

                                <!-- Helpdesk (6090)
                                Bradesco (9023)
                                Juridico Geral (9024)
                                Administrativo (9025)
                                Acordos Geral (9027)
                                Juridico 01 (9028)
                                Juridico 03 (9029)
                                Sicoob (9031)
                                Controladoria (9033)
                                BackOffice (9034)
                                Itapeva (9035)
                                Safra (9036) 
                                 -->
                                <fwb-table hoverable>
                                    <fwb-table-head>
                                    <fwb-table-head-cell>Grupo</fwb-table-head-cell>
                                    <fwb-table-head-cell>setor</fwb-table-head-cell>
                                    <fwb-table-head-cell><span class="">Ramal</span></fwb-table-head-cell>
                                    
                                    </fwb-table-head>
                                    <fwb-table-body>
                                    <fwb-table-row>
                                        <fwb-table-cell>Suporte/Helpdesk</fwb-table-cell>
                                        <fwb-table-cell>Tecnologia da informação</fwb-table-cell>
                                        <fwb-table-cell>6090</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Bradesco</fwb-table-cell>
                                        <fwb-table-cell>Setor de Acordos</fwb-table-cell>
                                        <fwb-table-cell>9023</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Administrativo</fwb-table-cell>
                                        <fwb-table-cell>Setor Administrativo</fwb-table-cell>
                                        <fwb-table-cell>9025</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Supervisão 1</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Execuções Bradesco)</fwb-table-cell>
                                        <fwb-table-cell>9028</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Supervisão 2</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Contrárias, Minutas, Consolidações e Execuções demais Bancos)</fwb-table-cell>
                                        <fwb-table-cell>9029</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Sicoob</fwb-table-cell>
                                        <fwb-table-cell>Setor de Acordos</fwb-table-cell>
                                        <fwb-table-cell>9021</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Controladoria</fwb-table-cell>
                                        <fwb-table-cell>Setor Controladoria</fwb-table-cell>
                                        <fwb-table-cell>9033</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Back Office</fwb-table-cell>
                                        <fwb-table-cell>Setor de Acordos</fwb-table-cell>
                                        <fwb-table-cell>9034</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Itapeva</fwb-table-cell>
                                        <fwb-table-cell>Setor de Acordos</fwb-table-cell>
                                        <fwb-table-cell>9035</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Safra</fwb-table-cell>
                                        <fwb-table-cell>Setor de Acordos</fwb-table-cell>
                                        <fwb-table-cell>9036</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Retomadas</fwb-table-cell>
                                        <fwb-table-cell>Setor de Retomadas</fwb-table-cell>
                                        <fwb-table-cell>9037</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>DivZero</fwb-table-cell>
                                        <fwb-table-cell>Setor de Acordos</fwb-table-cell>
                                        <fwb-table-cell>9021</fwb-table-cell>
                                    </fwb-table-row>
                                    </fwb-table-body>
                                </fwb-table>
                            </div>
                            <div class="mt-10">
                                <fwb-card href="#">
                                <div class="p-5">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Codigo de funcionalidades do telefone
                                    </h5>
                                    <p class="font-normal text-gray-700 dark:text-gray-400">
                                    **+ramal - puxa ligação<br>
                                    </p>
                                    <br>
                                    <br>
                                    <br>
                                    Obs: Caso  não consiga puxar uma ligação  como citado acima, abrir um chamado para que a TI possa fazer a alteração no telefone,<br>
                                    pois existem alguns telefone da marca GRANDSTREAM que não possuem o serviço ativo. Obrigado!
                                </div>
                                </fwb-card>
                            </div>
                        </div>
                        
                    </fwb-tab>
                    <fwb-tab name="Grupos de Emails" title="Grupos de Emails">
                        <div class="w-screen px-4 py-5 flex justify-content align-items">
                                <Icon name="laravel" class="h-10 w-10 mx-2" />
                                <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                                FOX ->
                                </h1>
                                <small class="ml-3 text-2xl font-bold text-gray-900 dark:text-white mx-1">Grupo de Emails</small>
                        </div>
                        <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                            <div class="card-body shadow-sm">

                                <!-- 
                                //acordos.divzero@dunice.adv.br
                                //acordos.itapeva@dunice.adv.br
                               // acordos.safra@dunice.adv.br
                               // acordos.sicoob@dunice.adv.br
                               // acordos@dunice.adv.br (bradesco)
                                //backoffice.juridico@dunice.adv.br
                                //controladoria@dunice.adv.br
                                //suporte@dunice.adv.br
                                //administrativo@dunice.adv.br (Útil)
                                //direcionamentos@dunice.adv.br 
                                //dp@dunice.adv.br 
                                //financeiro@dunice.adv.br 
                                //iniciais@dunice.adv.br 
                                //juridico@dunice.adv.br (Todos os setores Jurídicos)
                                //planejamento@dunice.adv.br 
                                //qualidade@dunice.adv.br 
                                //retomadas@dunice.adv.br 
                                //rh@dunice.adv.br 

                                //supervisao1@dunice.adv.br
                                //juridico2@dunice.adv.br
                                //juridico4@dunice.adv.br
                                //juridico5@dunice.adv.br

                                //supervisao2@dunice.adv.br
                                //juridico6@dunice.adv.br
                                contrarias@dunice.adv.br
                                minutas@dunice.adv.br
                                 -->
                                <fwb-table hoverable>
                                    <fwb-table-head>
                                    <fwb-table-head-cell>Grupo</fwb-table-head-cell>
                                    <fwb-table-head-cell>setor</fwb-table-head-cell>
                                    <fwb-table-head-cell><span class="">Chave de email</span></fwb-table-head-cell>
                                    
                                    </fwb-table-head>
                                    <fwb-table-body>
                                    <fwb-table-row>
                                        <fwb-table-cell>PADS</fwb-table-cell>
                                        <fwb-table-cell>Programa de automação e desenvolvimento de setores</fwb-table-cell>
                                        <fwb-table-cell>pads.dm@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Diretoria</fwb-table-cell>
                                        <fwb-table-cell>Diretores Dunice & Marcon</fwb-table-cell>
                                        <fwb-table-cell>diretoria@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Líderis de setor</fwb-table-cell>
                                        <fwb-table-cell>Setores</fwb-table-cell>
                                        <fwb-table-cell>liderancadm@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>    
                                    <fwb-table-row>
                                        <fwb-table-cell>Suporte/Helpdesk</fwb-table-cell>
                                        <fwb-table-cell>Suporte</fwb-table-cell>
                                        <fwb-table-cell>suporte@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Acordos Divzero</fwb-table-cell>
                                        <fwb-table-cell>Acordos</fwb-table-cell>
                                        <fwb-table-cell>acordos.divzero@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Acordos Itapeva</fwb-table-cell>
                                        <fwb-table-cell>Acordos</fwb-table-cell>
                                        <fwb-table-cell>acordos.itapeva@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Acordos Safra</fwb-table-cell>
                                        <fwb-table-cell>Acordos</fwb-table-cell>
                                        <fwb-table-cell>acordos.safra@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Acorodos Sicoob</fwb-table-cell>
                                        <fwb-table-cell>Acordos</fwb-table-cell>
                                        <fwb-table-cell>acordos.sicoob@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Acorodos Sicoob Unic</fwb-table-cell>
                                        <fwb-table-cell>Acordos</fwb-table-cell>
                                        <fwb-table-cell>acordos.sicoobunic@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Acorodos Bradesco</fwb-table-cell>
                                        <fwb-table-cell>Acordos</fwb-table-cell>
                                        <fwb-table-cell>acordos@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Back Office Juridico</fwb-table-cell>
                                        <fwb-table-cell>Setor Back Office</fwb-table-cell>
                                        <fwb-table-cell>backoffice.juridico@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Controladoria</fwb-table-cell>
                                        <fwb-table-cell>Setor Controladoria</fwb-table-cell>
                                        <fwb-table-cell>controladoria@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Administrativo</fwb-table-cell>
                                        <fwb-table-cell>Administrativo</fwb-table-cell>
                                        <fwb-table-cell>administrativo@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Direcionamentos</fwb-table-cell>
                                        <fwb-table-cell>Setor de Direcionamentos</fwb-table-cell>
                                        <fwb-table-cell>direcionamentos@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>DP</fwb-table-cell>
                                        <fwb-table-cell>Setor de DP</fwb-table-cell>
                                        <fwb-table-cell>dp@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Financeiro</fwb-table-cell>
                                        <fwb-table-cell>Setor Financeiro</fwb-table-cell>
                                        <fwb-table-cell>financeiro@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Iniciais</fwb-table-cell>
                                        <fwb-table-cell>Setor Iniciais</fwb-table-cell>
                                        <fwb-table-cell>iniciais@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Juridico</fwb-table-cell>
                                        <fwb-table-cell>Setor Juridico</fwb-table-cell>
                                        <fwb-table-cell>juridico@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Planejamento</fwb-table-cell>
                                        <fwb-table-cell>Setor Planejamento</fwb-table-cell>
                                        <fwb-table-cell>planejamento@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Qualidade</fwb-table-cell>
                                        <fwb-table-cell>Setor Qualidade</fwb-table-cell>
                                        <fwb-table-cell>qualidade@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Retomadas</fwb-table-cell>
                                        <fwb-table-cell>Setor Retomadas</fwb-table-cell>
                                        <fwb-table-cell>retomadas@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>RH</fwb-table-cell>
                                        <fwb-table-cell>Setor RH</fwb-table-cell>
                                        <fwb-table-cell>rh@duice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Supervisão 1</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Execuções Bradesco)</fwb-table-cell>
                                        <fwb-table-cell>supervisao1@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Juridico 2</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Anápolis, Rio Verde e Goiânia (varejo) )</fwb-table-cell>
                                        <fwb-table-cell>juridico2@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Juridico 4</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Cuiabá, Sinop, Palmas, Porto Velho, Private e Empresa)</fwb-table-cell>
                                        <fwb-table-cell>juridico4@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Juridico 5</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Goiânia (prime))</fwb-table-cell>
                                        <fwb-table-cell>juridico5@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Supervisão 2</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Contrárias, Minutas, Consolidações e Execuções demais Bancos)</fwb-table-cell>
                                        <fwb-table-cell>supervisao2@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Juridico 6</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Execução regional Brasilia Bradesco e Execuções demais Bancos)</fwb-table-cell>
                                        <fwb-table-cell>contrarias@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    <fwb-table-row>
                                        <fwb-table-cell>Minutas</fwb-table-cell>
                                        <fwb-table-cell>Setor de Juridico (Contrárias, Minutas, Consolidações e Execuções demais Bancos)</fwb-table-cell>
                                        <fwb-table-cell>minutas@dunice.adv.br</fwb-table-cell>
                                    </fwb-table-row>
                                    </fwb-table-body>
                                </fwb-table>
                            </div>
                            
                        </div>
                        
                    </fwb-tab>
                    
            </fwb-tabs>
            
        </div>
        <Footer />
    </div>
</template>
