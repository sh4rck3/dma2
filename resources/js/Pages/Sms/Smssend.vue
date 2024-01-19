<script setup>
import AppLayout from '@/Layouts/AppLayoutLanding.vue';
import { FwbCard, FwbImg  } from 'flowbite-vue';
</script>

<template>
    <AppLayout title="SMS">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Envio de SMS
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        Para nossa segurança as mensagens de SMS só poderão ser enviadas mediante login no sistema.
                        
                        </h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">
                            Após logar e preciso acessar o menu geral como mostra o imagem abaixo.<br>
                            Desta forma ira aparecer o submenu SMS.<br>
                            Ao clicar no submenu SMS ira aparecer a tela de envio de SMS.<br>
                            Envie quantos precisar.<br>
                        </p>
                    </div>
                    <fwb-img
                    alignment="mx-auto"
                    size="max-w-lg"
                    alt="Envio de SMS"
                    src="storage/uploads/envioDeSms.png"
                />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
