<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import { reactive, ref } from 'vue'
import { FwbInput, FwbTextarea, FwbButton  } from 'flowbite-vue'

const form = reactive({
  telephone: null,
  cpf: null,
  message: null,
})

const retorno = reactive({
    cpf: '4874547894',
    status: 'enviado',
    message: 'olá',
})

function submit() {
 console.log(form)
}

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <form @submit.prevent="submit">
                
                <fwb-input 
                    id="telephone" 
                    v-model="form.telephone" 
                    label="Telefone"
                    required
                    v-mask="'(00) 00000-0000'"
                    />
                <fwb-input
                    id="cpf"
                    v-model="form.cpf"
                    label="CPF"
                    required
                    placeholder="123.456.789-10"
                    v-mask="'000.000.000-00'"
                />

                <fwb-textarea
                    id="message"
                    v-model="form.message"
                    :rows="4"
                    label="Mensagem"
                    required
                />
               
                <fwb-button color="default">Enviar</fwb-button>
            </form>
        </div>
        <Footer />
    </div>
</template>
