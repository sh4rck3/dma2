<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { ref } from 'vue';
    import Icon from '@/Icons/Icon.vue';
    import {
        FwbA,
        FwbTable,
        FwbTableBody,
        FwbTableCell,
        FwbTableHead,
        FwbTableHeadCell,
        FwbTableRow,
    } from 'flowbite-vue'

    const itens = ref([
        {
            id: "1",
            nome: "João",
            numero: "98756456",
            mensagem: "Olá, seu pagamento da fatura de junho está atrasado. Por favor, faça o pagamento o mais rápido possível para evitar cobranças de juros. Obrigado.",
            status: "Enviado",
        },
        {
            id: "2",
            nome: "Julia",
            numero: "96498745",
            mensagem: "oi",
            status: "Enviado",
        },
        {
            id: "3",
            nome: "Rafael",
            numero: "98416847",
            mensagem: "hi",
            status: "Enviado",
        },
        {
            id: "4",
            nome: "Isadora",
            numero: "94716541",
            mensagem: "hello",
            status: "Enviado",
        },
    ])
</script>

<template>
    <AppLayout title="SMS">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Histórico de SMS
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <!--
                    <div v-for="item in itens" :key="item.id">
                        {{ item.nome }}
                    </div>
                    -->
                    
                    <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                <div class="card-body shadow-sm">
                    <div class="table-responsive">
                        <fwb-table>
                            <fwb-table-head>
                            <fwb-table-head-cell>Código</fwb-table-head-cell>
                            <fwb-table-head-cell>Nome</fwb-table-head-cell>
                            <fwb-table-head-cell>Número</fwb-table-head-cell>
                            <fwb-table-head-cell>Mensagem</fwb-table-head-cell>
                            <fwb-table-head-cell>Status</fwb-table-head-cell>
                            <fwb-table-head-cell>
                                <span class="sr-only">Edit</span>
                            </fwb-table-head-cell>
                            </fwb-table-head>
                            <fwb-table-body>
                            <fwb-table-row v-for="item in itens" :key="item.id" >
                                <fwb-table-cell>{{item.id}}</fwb-table-cell>
                                <fwb-table-cell>{{item.nome}}</fwb-table-cell>
                                <fwb-table-cell>{{item.numero}}</fwb-table-cell>
                                <fwb-table-cell>{{ item.mensagem }}</fwb-table-cell>
                                <fwb-table-cell>{{ item.status }}</fwb-table-cell>
                                <fwb-table-cell>
                                <fwb-a href="#">
                                    <Icon name="trash2" class="h-5 w-5"/>
                                </fwb-a>
                                </fwb-table-cell>
                            </fwb-table-row>
                            </fwb-table-body>
                        </fwb-table>
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    
    </AppLayout>
</template>