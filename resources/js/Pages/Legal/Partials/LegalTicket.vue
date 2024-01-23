<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import Icon from '@/Icons/Icon.vue';
import { FwbInput, FwbButton, FwbTextarea, FwbFileInput, FwbSelect } from 'flowbite-vue';
import { ref, reactive, inject } from 'vue';
const swal = inject('$swal');


const form = reactive({
  title: null,
  selected: 'Aberto',
  nameFile: null,
  description: null,
  file: null,
})

const priority = [
  { value: '1', name: 'Aberto' },
  { value: '2', name: 'Andamento' },
  { value: '3', name: 'Concluido' },
]


function submit(){
    //console.log(form)
    const config = { headers: { 'Content-Type': 'multipart/form-data' } };
    axios.post('/api/legal/store', form, config)
             .then(response => {
                //console.log(response.data)
                if(response.data.status == true){                     
                     swal(response.data.title, response.data.message, "success");                   
                     form.title = ""
                     form.selected = ""
                     form.description = ""
                     form.nameFile = ""
                     form.file = ""
                 }else{
                     swal(response.data.title, response.data.message, "error");
                 }
             })
             .catch(err => () => this.$swal("Erro", err.data.message, "error")
                 //console.log(err.data)
                 );
}

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                <Icon name="laravel" class="h-10 w-10 mx-2" />
                <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                Adicionar novo pedido a fila
                </h1>
               
            </div>
           
            
            <form @submit.prevent="submit" class="ml-6 mr-6">
                
                <fwb-input
                    type="text" 
                    id="title" 
                    v-model="form.title" 
                    label="Título"
                    placeholder="Insira o título do seu pedido aqui"
                    />
                    <fwb-select
                        v-model="form.selected"
                        :options="priority"
                        label="Selecione a prioridade"
                        size="sm"
                    />
                    <fwb-input
                    type="text"
                    v-model="form.nameFile" 
                    label="Nome do arquivo"
                    placeholder="Nome do arquivo anexado(Opcional)"
                    />
                    <fwb-textarea
                    v-model="form.description"
                    rows="4"
                    label="Descrição sobre inicial"
                    placeholder="Insira sua mensagem aqui"
                     />
                    <fwb-file-input v-model="form.file" label="Anexo" size="sm" />
                    <fwb-button type="submit" class="mt-2">
                    Enviar!
                    </fwb-button>
            </form>
            
        </div>
        <Footer />
    </div>
</template>
