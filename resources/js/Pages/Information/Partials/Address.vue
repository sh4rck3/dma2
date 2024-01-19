<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import Icon from '@/Icons/Icon.vue';
import { FwbCard } from 'flowbite-vue';


</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                <Icon name="laravel" class="h-10 w-10 mx-2" />
                <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                Dados da empresa
                </h1>
               
            </div>
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                <smal class="font-medium text-gray-900 dark:text-white mx-2 my-2">
                    Endereço e telefones de matriz e filiais.
                </smal>
            </div>
            <div class="flex">
                <fwb-card
                class="mr-2"
                img-alt="Desk"
                img-src="/storage/uploads/PalacioDoComercio.png"
                variant="image"
                >
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Matriz - Dunice Marcon Advogados BSB
                    </h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                    Localizado no Setor Comercial Sul, Ed. Palácio do Comércio, Sobreloja, sala 34, Asa Sul, Brasília-DF.<br>
                    CEP: 70.318-900<br>
                    Telefone: (61) 3578-8484<br>
                    </p>
                </div>
                </fwb-card>
                <fwb-card
                img-alt="Desk"
                img-src="/storage/uploads/OfficeTower.png"
                variant="image"
                >
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Filial 1- Dunice Marcon Advogados GYN
                    </h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                    Localizado no Setor Oeste , Ed. Office Tower, Térreo, sala 03, Goiânia - GO.<br>
                    CEP: 70.318-900<br>
                    Telefone: (62) 3942-0771<br>
                    </p>
                </div>
                </fwb-card>
                <fwb-card
                class="ml-2"
                img-alt="Desk"
                img-src="/storage/uploads/AmericanBusines.png"
                variant="image"
                >
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Filial 2- Dunice Marcon Advogados CGB
                    </h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">
                    Localizado centro de Cuiabá ,  Edifício América Business Center - Av. Historiador Rubens de Mendonça, 2052 - Jardim Aclimação, Cuiabá - MT, - 14ª Andar - Sala 1405.<br>
                    CEP: 78053-835<br>
                    Telefone: (62) 3942-0771<br>
                    </p>
                </div>
                </fwb-card>
            </div>
            
          
        </div>
        <Footer />
    </div>
</template>
