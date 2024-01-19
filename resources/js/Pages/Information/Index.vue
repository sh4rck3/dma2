<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from './Partials/Extension.vue';
import Singlesms from './Partials/Contentsingle.vue';
import Responsesms from './Partials/Smsresponse.vue';
import Birthday from './Partials/Birthday.vue';
import Address from './Partials/Address.vue';
import { ref } from 'vue'
import { FwbTab, FwbTabs } from 'flowbite-vue'

const activeTab = ref('Ramais')

</script>

<template>
    <AppLayout title="Ramais">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Acesso a informações no Geral
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <fwb-tabs v-model="activeTab" class="p-5">
                    <fwb-tab name="Ramais" title="Ramais">
                    <Welcome />
                    </fwb-tab>
                    <fwb-tab name="SMS" title="SMS">
                    <Singlesms />
                    </fwb-tab>
                    <fwb-tab name="SMS Resposta" title="SMS Resposta">
                    <Responsesms />
                    </fwb-tab>
                    <fwb-tab name="Aniversariantes" title="Aniversariantes">
                    <Birthday />
                    </fwb-tab>
                    <fwb-tab name="Endereço" title="Endereço">
                    <Address />
                    </fwb-tab>
                    <fwb-tab name="Dados" title="Dados" disabled>
                    Lorem ipsum dolor...
                    </fwb-tab>
                </fwb-tabs>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
