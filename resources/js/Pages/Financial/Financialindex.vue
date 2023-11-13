<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Modalflowbite from '@/Components/Modalflowbite.vue';
</script>
<script>
import { TailwindPagination } from 'laravel-vue-pagination';
import throttle from 'lodash/throttle';

export default {
    components: {
        TailwindPagination
    },
    data() {
        return {
            financials: [],
            financialsSum: '',
            pagination: {},
            keepLength: false,
            limit: 2,
            form: {
                search: this.search,
            },
        };
    },
    watch: {
        form: {
        deep: true,
        handler: throttle(function () {
            axios.get('api/financialindex?name=' + this.form.search, { preserveState: true }).then((response) => {
                //console.log(response);
                this.financials = response.data.financials.data;
                this.pagination = response.data.financials;

                this.financialsSum = response.data.financialsSum;
                //console.log(this.financialsSum);
            });
        }, 150),
        },
    },

    methods: {
        getFinancial (page = 1) {
            //console.log(page);
            
            axios.get('/api/financialindex?page=' + page).then(response => {
                  this.financials = response.data.financials.data;
                  this.pagination = response.data.financials;
            });
        },
        formatMoney (value) {
            return value.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
        },
        testeVal (value1) {
            //console.log(value);
            const teste = value1.toLocaleString('pt-BR')
           // console.log(alterandoValor);
        },
    },

    mounted() {
        axios.get('/api/financialindex').then(response => {
            this.financials = response.data.financials.data;
            this.pagination = response.data.financials;

            this.financialsSum = response.data.financialsSum;
            //console.log(this.financialsSum);
            // let valor = JSON.stringify(this.pagination);
            // this.paginationProxy = JSON.parse(valor);
            // console.log(this.paginationProxy);
        });
    },

   
};



</script>

<template>
    <AppLayout title="Painel">
        <template #header>
            <div class="flex justify-between">
                    <div class="">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Remessa Bradesco
                        </h2>
                        <span class="text-white">{{ formatMoney(financialsSum) }}</span>
                    </div>
                    <div class="">
                        <input 
                        v-model="form.search"
                        type="text" class="form-control" placeholder="Pesquisar...">
                    </div>
                    <div class="">
                        <a href="/financialimport">
                            <button class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded align-middle">
                                Importar Remessa
                            </button>
                        </a>
                    </div>
                </div>
        </template>

        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                     <!--list financial-->
                     <div class="text-xs">
                        <table class="w-full whitespace-nowrap text-gray-400">
                            <tr class="text-left font-bold">
                                <th class="pb-1 pt-3 px-2">Rem</th>
                                <th class="pb-1 pt-3 px-2">GCPJ</th>
                                <th class="pb-1 pt-3 px-2">UF</th>
                                <th class="pb-1 pt-3 px-2">N. Processo</th>
                                <th class="pb-1 pt-3 px-2">Ação Ajuiz.</th>
                                <th class="pb-1 pt-3 px-2">Reu/Autor</th>
                                <th class="pb-1 pt-3 px-2">Banco Emp.</th>
                                <th class="pb-1 pt-3 px-2">Nome</th>
                                <th class="pb-1 pt-3 px-2">CPF/CNPJ</th>
                                <th class="pb-1 pt-3 px-2">ndbqcng</th>
                                <th class="pb-1 pt-3 px-2">cdbqcng</th>
                                <th class="pb-1 pt-3 px-2">Agência</th>
                                <th class="pb-1 pt-3 px-2">Conta</th>
                                <th class="pb-1 pt-3 px-2">Contrato</th>
                                <th class="pb-1 pt-3 px-2">Descricao</th>
                                <th class="pb-1 pt-3 px-2">Valor</th>
                                <th class="pb-1 pt-3 px-2">Carteira</th>                                        
                                <th class="pb-1 pt-3 px-2">Ações</th>
                            </tr>
                            <tr 
                            v-for="financial in financials" :key="financial.id" 
                            class="hover:bg-gray-100 focus-within:bg-gray-100">
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2 focus:text-indigo-500">
                                        {{ financial.num_remessa }}
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2 focus:text-indigo-500">
                                        {{ financial.num_gcpj }}
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.uf }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.num_processo }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.acao_ajuizada }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.reu_autor }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.empresa_banco }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.nome_cliente }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.cpf_cnpj }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.ndbqcng }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.cdbqcng }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.agencia }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.conta }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.contrato }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.descricao_despesas }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ formatMoney(Number(financial.valor)) }}
                                        </div>
                                    </a>
                                </td>
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                            {{ financial.carteira }}
                                        </div>
                                    </a>
                                </td>
                                
                                <td class="border-t">
                                    <a class="flex items-center px-0.5 py-2  focus:text-indigo-500" >
                                        <div>
                                           <Modalflowbite
                                           :numGcpj="financial.num_gcpj"
                                           :codEscritorio="financial.cod_escritorio"
                                           :carteira="financial.carteira"
                                           :justDuplicidade="financial.justifi_duplicidade"
                                           />
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="financials.length === 0">
                                <td class="px-6 py-2 border-t" colspan="18">Nenhum registro encontrado.</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="w-auto px-4 py-5 flex justify-center">
                    <TailwindPagination
                        :data="pagination"
                        :limit="limit"
                        :keep-length="keepLength"
                        @pagination-change-page="getFinancial"
                        />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
