<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { ref, watch } from 'vue'
    import { FwbInput, FwbFileInput, FwbButton, FwbTextarea } from 'flowbite-vue'

    const file = ref(null); 
    const isValidFile = ref(false);

    function validateFile(file) {
    if (file && file.name.endsWith('.csv') || file && file.name.endsWith('.xlsx')) {
        isValidFile.value = true;
    } else {
        isValidFile.value = false;
        alert("Por favor, selecione um arquivo CSV.");
    }
    }

    watch(file, (newFile) => {
        validateFile(newFile);
    });
</script>

<template>
    <AppLayout title="SMS">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Importar Sms
            </h2>
        </template>

        <div class="p-6 lg:p-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">               
                <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed overflow-hidden sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                        <fwb-input
                            v-model="name"
                            label="Nome"
                        />
                        <fwb-textarea
                            v-model="message"
                            :rows="4"
                            label="Mensagem"
                        />
                        <fwb-file-input v-model="file" label="Arquivo"/>
                        <div class="flex justify-end">
                            <fwb-button class="mt-6" color="default" :disabled="!isValidFile">Importar</fwb-button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        
    </AppLayout>
</template>