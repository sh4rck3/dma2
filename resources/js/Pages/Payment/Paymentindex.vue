<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Icon from '@/Icons/Icon.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import throttle from 'lodash/throttle';




export default {
    components: {
        AppLayout,
        Icon,
        TailwindPagination,
       
    },
    
    data() {
        return {
            tickets: [],
            payments: [],
            results: [],
            proxypayments: [],
            pagination: {},
            form: {
                search: this.search,
            },
        };
    },
    watch: {
        form: {
        deep: true,
        handler: throttle(function () {
            axios.get('api/tickets?title=' + this.form.search, { preserveState: true }).then((response) => {
                //console.log(response);
                this.tickets = response.data.tickets.data;
                this.pagination = response.data.tickets;
            });
        }, 150),
        },
    },
    methods: {
        getTickets (page = 1) {
            //console.log(page);
            axios.get('/api/tickets?page=' + page).then(response => {
                  this.tickets = response.data.tickets.data;
                  this.pagination = response.data.tickets;
            });
        },
    },
    mounted() {
        axios.get('/api/payment').then(response => {
            this.payments = response.data.payments;
            let valor = JSON.stringify(this.payments);
            this.proxypayments = JSON.parse(valor);            
            this.proxypayments.filter((value) => {
                this.results.push({
                    mes: value,
                });
            });
        });
        console.log(this.proxypayments);
    },

   
};



</script>

<template>
    <AppLayout title="Lista de pagamentos">
        <template #header>
            <div class="flex justify-between">
                    <div class="">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Pagamentos importados
                        </h2>
                    </div>
                    <div class="">
                        <input 
                        v-model="form.search"
                        type="text" class="form-control" placeholder="Pesquisar..." hidden>
                    </div>
                    <div class="">
                        <a href="/paymentsimport">
                            <button class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded align-middle">
                                Importar XML 
                            </button>
                        </a>
                    </div>
                </div>
        </template>

        
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <!--list users-->
                            <div>
                                <table class="w-full whitespace-nowrap">
                                    <tr class="text-left font-bold">
                                        <th class="pb-4 pt-6 px-6">Mes</th>
                                        <th class="pb-4 pt-6 px-6">Ações</th>
                                    </tr>
                                    <tr v-for="result in results" :key="result.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                        <td class="border-t">
                                            <a class="flex items-center px-6 py-4 focus:text-indigo-500">
                                                {{ result.mes }}
                                            </a>
                                        </td>
                                      
                                        
                                        <td class="border-t">
                                            
                                                <div class="flex">
                                                    <a :href="`/useradminedit/${result.id}`"><icon name="edit" class="mr-2 w-4 h-4" /></a>
                                                    <a :href="`/useradminedit/${result.id}`"><icon name="trash" class="mr-2 w-4 h-4" /></a>
                                                    
                                                </div>
                                            
                                        </td>
                                    </tr>
                                    <tr v-if="results.length === 0">
                                        <td class="px-6 py-4 border-t" colspan="4">Nenhum chamado encontrado.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="w-auto px-4 py-5 flex justify-center">
                            <TailwindPagination
                                :data="this.pagination"
                                @pagination-change-page="getTickets"
                            /> 
                        </div>
                    </div>
                </div>
    </AppLayout>
</template>
