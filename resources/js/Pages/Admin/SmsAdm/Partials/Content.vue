<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import Icon from '@/Icons/Icon.vue';
import { FwbInput, FwbButton, FwbTextarea } from 'flowbite-vue';
import { ref, reactive, inject } from 'vue';
const swal = inject('$swal');


const itens = ref([
{
  id:"1",
  cpf: "789.56.152-02",
  phone: "5561975635",
  mensage: "Hello peaple",
},{
    id:"2",
  cpf: "789.45.123-02",
  phone: "5561984456998",
  mensage: "Hello guys",
},{
    id:"3",
  cpf: "789.45.123-02",
  phone: "5561984456998",
  mensage: "Hello There",
},{
    id:"4",
  cpf: "789.45.123-02",
  phone: "5561984456998",
  mensage: "Hello There",
}
]);


const name = ref('')


</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                <Icon name="laravel" class="h-10 w-10 mx-2" />
                <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                FOX -> SMS
                </h1>
               
            </div>
            <div class="table-responsive text-white">
            <table class="table">
                            <thead>
                           
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex flex-row">
                                        <div class="font-medium text-uppercase">
                                            CPF
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex flex-row">
                                        <div class="font-medium text-uppercase">
                                            Telefone
                                        </div>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left">
                                    <div class="flex flex-row">
                                        <div class="font-medium text-uppercase">
                                            Mensagem
                                        </div>
                                    </div>
                                </th>
                                
                            </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="iten in itens" :key="iten.id">
                                    <td class="px-6 py-4 text-sm">
                                        {{ iten.cpf }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ iten.phone }} 
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        {{ iten.mensage }}
                                    </td>
                                   
                        
                                </tr>
                            
                            
                            </tbody>
                        </table>
            </div>
        </div>
        <Footer />
    </div>
</template>