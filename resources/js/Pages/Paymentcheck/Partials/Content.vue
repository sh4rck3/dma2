<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import Icon from '@/Icons/Icon.vue';
import axios from 'axios';
import { FwbInput, FwbButton, FwbTextarea, FwbA, FwbTable, FwbTableBody, FwbTableCell, FwbTableHead, FwbTableHeadCell, FwbTableRow, FwbTab, FwbTabs } from 'flowbite-vue';
import { ref, reactive, inject, onMounted } from 'vue';
const swal = inject('$swal');
const activeTab = ref('first');
const responseapis = ref('')

onMounted(() => {
    //console.log("Teste")
    axios.get('/api/paycheckadm').then(function (response) {
        //console.log(response.data)
        const responseapis = response.data.data
        //console.log(responseapis.data[0].email)

    })
});

axios({
  method: 'get',
  url: 'https://fox.dunice.com.br/api/paycheckadm',
  responseType: 'json'
})
  .then(function (response) {
    const responseapis = response.data.data
  });

const itens = ref([
{
  id:"1",
  month: "10/2023",
  importuser: "admin",
  datehour: "15/12/2023 - 15h23",
},{
    id:"2",
    month: "11/2023",
  importuser: "admin",
  datehour: "16/12/2023 - 12h30",
},{
    id:"3",
    month: "12/2023",
  importuser: "admin",
  datehour: "20/12/2023 - 10h45",
},{
    id:"4",
    month: "01/2024",
  importuser: "admin",
  datehour: "23/12/2023 - 18h00",
}
]);


//const name = ref('')


</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                <Icon name="laravel" class="h-10 w-10 mx-2" />
                <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                FOX -> Contracheque
                </h1>
               
            </div>
            <div>
                <fwb-tabs v-model="activeTab" variant="underline" class="p-5">
                    <fwb-tab name="month" title="Meses">
                        <fwb-table hoverable>
                        <fwb-table-head>
                        <fwb-table-head-cell>Mês</fwb-table-head-cell>
                        <fwb-table-head-cell>Importer User</fwb-table-head-cell>
                        <fwb-table-head-cell>Data da Importação</fwb-table-head-cell>
                        <!-- <fwb-table-head-cell>Visualização</fwb-table-head-cell> -->
                        <fwb-table-head-cell>Ações</fwb-table-head-cell>
                        </fwb-table-head>
                        <fwb-table-body>
                        <fwb-table-row  v-for="iten in itens" :key="iten.id">
                            <fwb-table-cell>{{iten.month}}</fwb-table-cell>
                            <fwb-table-cell>{{iten.importuser}}</fwb-table-cell>
                            <fwb-table-cell>{{iten.datehour}}</fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-button color=""><Icon name="lockclosed" class="w-10 h-10"/></fwb-button>
                            </fwb-table-cell>
                        </fwb-table-row>
                        </fwb-table-body>
                    </fwb-table>
                    </fwb-tab>
                    <fwb-tab name="person" title="Por Colaborador">
                        <fwb-table hoverable>
                        <fwb-table-head>
                        <fwb-table-head-cell>Mês</fwb-table-head-cell>
                        <fwb-table-head-cell>Nome Colaborador</fwb-table-head-cell>
                        <fwb-table-head-cell>Visualização</fwb-table-head-cell>
                        <fwb-table-head-cell>Ações</fwb-table-head-cell>
                        </fwb-table-head>
                        <fwb-table-body>
                        <fwb-table-row  v-for="responseapi in responseapis" :key="responseapi.id">
                            <fwb-table-cell>{{responseapi.name}}</fwb-table-cell>
                            <fwb-table-cell>{{responseapi.email}}</fwb-table-cell>
                            <fwb-table-cell>{{responseapi.paymentstatus}}</fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-button color=""><Icon name="lockclosed" class="w-10 h-10"/></fwb-button>
                            </fwb-table-cell>
                        </fwb-table-row>
                        </fwb-table-body>
                    </fwb-table>
                    </fwb-tab>
                </fwb-tabs>
            </div>
        </div>
        <Footer />
    </div>
</template>