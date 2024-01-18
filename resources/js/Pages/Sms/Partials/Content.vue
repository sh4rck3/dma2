<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import Icon from '@/Icons/Icon.vue';
import { FwbInput, FwbButton, FwbTextarea } from 'flowbite-vue';
import { ref, reactive, inject } from 'vue';
const swal = inject('$swal');


const form = reactive({
  cpf: null,
  phone: null,
  mensage: null,
})
const formClean = reactive({
  cpf: "",
  phone: "",
  mensage: "",
})


const name = ref('')

function submit(){
    console.log(form)
    swal("Enviado com sucesso!")
    //form.reset()
    form.cpf = ""
    form.phone = ""
    form.mensage = ""
    //console.log('o nome escrito e: ' + this.name)
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
                    placeholder="Insira seu CPF aqui"
                    />
                <fwb-input
                    class="mt-2 mb-1"
                    type="text"
                    id="phone"
                    v-mask="'(00)00000-0000'" 
                    v-model="form.phone" 
                    label="Telefone"
                    placeholder="Insira seu número de telefone aqui"
                    />
                    <fwb-textarea
                    v-model="form.mensage"
                    rows="4"
                    label="Sua Mensagem"
                    placeholder="Insira sua mensagem aqui"
                     />
            
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
