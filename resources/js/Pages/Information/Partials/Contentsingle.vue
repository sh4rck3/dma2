<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import Icon from '@/Icons/Icon.vue';
import { FwbInput, FwbButton, FwbTextarea } from 'flowbite-vue';
import { ref, reactive, inject } from 'vue';
const swal = inject('$swal');
const maxLength = 120;
const form = reactive({
  cpf: null,
  phone: null,
  message: '',
})
const formClean = reactive({
  cpf: "",
  phone: "",
  message: "",
})



const name = ref('')

function submit(){
    //console.log(form)
    axios.post('/api/sendsms', {
                 phone: form.phone,
                 message: form.message,
                 document: form.cpf,
             })
             .then(response => {
                console.log(response.data)
                if(response.data.status == true){                     
                     swal(response.data.title, response.data.message, "success");                   
                     form.cpf = ""
                     form.phone = ""
                     form.message = ""
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
                FOX -> SMS
                </h1>
               
            </div>
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                <smal class="font-medium text-gray-900 dark:text-white mx-2 my-2">
                    Nos envie sua mensagem via SMS por aqui! Basta preencher os campos abaixo corretamente e enviar!
                </smal>
            </div>
            
            <form @submit.prevent="submit" class="ml-6 mr-6">
                
                <fwb-input
                    type="text" 
                    id="cpf" 
                    v-mask-cpf
                    v-model="form.cpf" 
                    label="CPF"
                    placeholder="Insira o CPF do cliente(destinarário)"
                    />
                <fwb-input
                    class="mt-2 mb-1"
                    type="text"
                    id="phone"
                    v-mask="'(00)00000-0000'" 
                    v-model="form.phone" 
                    label="Telefone"
                    placeholder="Ex: (11)99999-9999"
                    />
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mensagem</label>
                    <textarea
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    v-model="form.message"
                    rows="4"
                    label="Sua Mensagem(120 caracteres max.)"
                    placeholder="Insira sua mensagem aqui, max. 120 caracteres e não pode conter caracteres especiais."
                    :maxlength="maxLength"
                     />
                     <div class="input-group-addon" v-text="(maxLength - form.message.length)"></div>
                    <fwb-button type="submit" class="mt-2">
                    Enviar!
                    </fwb-button>
            </form>
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                <smal class="font-medium text-gray-900 dark:text-white mx-2 my-2">
                    Caso haja algum problema, basta abrir um chamado no GLPI que resolveremos assim que possível.
                </smal>
            </div>
        </div>
        <Footer />
    </div>
</template>
