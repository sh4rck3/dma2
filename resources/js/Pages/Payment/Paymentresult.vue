<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import Icon from '@/Icons/Icon.vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import throttle from 'lodash/throttle';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';





export default {
    components: {
        AppLayout,
        Icon,
        FormSection,
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        TailwindPagination,
        DialogModal,
        DangerButton,
        SecondaryButton,
    },
    
    data() {
        return {
            payments: [],
            results: [],
            proxypayments: [],
            pagination: {},
            showModal: false,
            passwordInput: '',
            form: this.$inertia.form({
                description: '',
                status: '',
                password: '',
            }),
        };
    },
    watch: {
        form: {
        deep: true,
        handler: throttle(function () {
            axios.get('api/paymentuser?title=' + this.form.search, { preserveState: true }).then((response) => {
                //console.log(response);
                this.tickets = response.data.tickets.data;
                this.pagination = response.data.tickets;
            });
        }, 150),
        },
    },
    methods: {
        
        clickshowModal (idPayment, statusValue) {
            if(statusValue == 1){
                this.$inertia.visit("/paymentshow/"+idPayment);
            }else{
                this.idPayment = idPayment;
                this.showModal = true; 
            }      
        },
        closeModal () {
            this.showModal = false;
            this.form.status = '';
        },
        closeModalAceite (idPaymentConfirm) {
            axios.get(`/api/payment/confirm/${idPaymentConfirm}`)
                .then(response => {
                    this.showModal = false;
                    setTimeout(() => {
                            this.$inertia.visit("/paymentshow/"+idPaymentConfirm);
                        }, 200);
                    //window.location.href = '/paymentshow/' + idPaymentConfirm;
                });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
                // Then specify how you want your dates to be formatted
            return new Intl.DateTimeFormat('default', {dateStyle: 'long'}).format(date);
        }
    },
    mounted() {
        axios.get('/api/paymentuser').then(response => {
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
    <AppLayout title="Lista de contracheque">
        <template #header>
            <div class="flex justify-between">
                    <div class="">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Lista de contracheques
                        </h2>
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
                                        <th class="pb-4 pt-6 px-6">Visualizado</th>
                                        <th class="pb-4 pt-6 px-6">Data da Visualização</th>
                                        <th class="pb-4 pt-6 px-6">Ações</th>
                                    </tr>
                                    <tr v-for="result in results" :key="result.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                                        <td class="border-t">
                                            <a class="flex items-center px-6 py-4 focus:text-indigo-500">
                                                {{ result.mes.mesRef }}
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a class="flex items-center px-6 py-4 focus:text-indigo-500">                                                
                                                <icon v-if="result.mes.status == 1" name="checkcircle" class="mr-2 w-6 h-6 text-green-800"></icon>
                                                <icon v-else name="xcircle" class="mr-2 w-6 h-6 text-red-800"></icon>
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <a v-if="result.mes.dataAssinatura != null" class="flex items-center px-6 py-4 focus:text-indigo-500">
                                                {{ formatDate(result.mes.dataAssinatura) }}
                                            </a>
                                            <a v-else class="flex items-center px-6 py-4 focus:text-indigo-500">
                                                Não visualizado
                                            </a>
                                        </td>
                                        <td class="border-t">
                                            <div class="flex">
                                                <button
                                                    class="ml-3"
                                                    @click="clickshowModal(result.mes.id, result.mes.status)"
                                                    
                                                    >
                                                            <icon name="eye" class="mr-2 w-6 h-6"></icon> 
                                                </button>
                                                <!-- <a :href="`/paymentshow/${result.mes.id}`"><icon name="eye" class="mr-2 w-4 h-4" /></a> -->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="results.length === 0">
                                        <td class="px-6 py-4 border-t" colspan="4">Nenhum contracheque até o momento.</td>
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
                         <!-- Confirmation Modal -->
                         <DialogModal :show="showModal" @close="closeModal">
                                <template #title>
                                    Termo de aceite
                                </template>

                                <template #content>
                                    Ao abrir o contracheque, você concorda com os termos de uso do sistema.
                                    Dentro das normas de segurança da empresa, este documento é de uso exclusivo do colaborador.
                                    Não é permitido o compartilhamento com terceiros.
                                    Caso tenha alguma dúvida, entre em contato com o RH.<br>
                                    Ramal: 7017<br>
                                    email: greicy.ribeiro@dunice.adv.br<br>
                                </template>

                                <template #footer>
                                    <SecondaryButton @click="closeModal">
                                        Cancelar
                                    </SecondaryButton>

                                    <DangerButton
                                        class="ml-3"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        @click="closeModalAceite(this.idPayment)"
                                    >
                                        Aceito os termos
                                    </DangerButton>
                                </template>
                            </DialogModal> 
                    </div>
                </div>
    </AppLayout>
</template>
