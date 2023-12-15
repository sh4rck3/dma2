<script setup>
    import { 
      FwbCard, 
      FwbButton, 
      FwbA,
      FwbTable,
      FwbTableBody,
      FwbTableCell,
      FwbTableHead,
      FwbTableHeadCell,
      FwbTableRow, 
    } from 'flowbite-vue'
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { ref } from 'vue';
    import Icon from '@/Icons/Icon.vue';

    const itens = ref([
        {
            id: "1",
            nome: "Cobrança 15/12",
            mensagem: "pagamento o mais rápido possível para evitar cobranças de juros. Obrigado.",
            status: "Enviado",
        },
      ])

    function importlink(){
      window.location.href = '/smsadmimport'
    }

</script>


<template>
  <AppLayout title="SMS">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Remessas
        </h2>
        <fwb-button v-on:click="importlink()" color="default" class="mr-2">Importar</fwb-button>
      </div>                      
    </template>

      <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">                   
                    <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                      <div class="card-body shadow-sm flex justify-around flex-wrap">
                        <fwb-card href="#" class="m-2 w-1/3">
                          <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                              Enviados
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-lg">
                              102
                            </p>
                          </div>
                        </fwb-card>
                        <fwb-card href="#" class="m-2 w-1/3">
                          <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                              Pendentes
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-lg">
                              10
                            </p>
                          </div>
                        </fwb-card>
                        <fwb-card href="#" class="m-2 w-1/3">
                          <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
                              Não Enviados
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400 text-center text-lg">
                              17
                            </p>
                          </div>
                        </fwb-card>
                      </div>
                      <div>
                        <fwb-table>
                            <fwb-table-head>
                            <fwb-table-head-cell>Código</fwb-table-head-cell>
                            <fwb-table-head-cell>Nome</fwb-table-head-cell>
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
                                <fwb-table-cell>{{ item.mensagem }}</fwb-table-cell>
                                <fwb-table-cell>{{ item.status }}</fwb-table-cell>
                                <fwb-table-cell>
                                  <fwb-a href="#">
                                    <Icon name="trash2" class="h-5 w-5 mr-2"/>
                                </fwb-a>
                                
                                <fwb-a href="#">
                                    <Icon name="airplane" class="h-5 w-5"/>
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
        

      
  
  </AppLayout>
</template>