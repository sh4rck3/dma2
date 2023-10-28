<script setup>
import Icon from '@/Icons/Icon.vue';
import Carousel from '@/Components/Landings/Carousel.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                
                    <Icon name="laravel" class="h-10 w-10 mx-2" />
                
                
                    <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                       FOX
                    </h1>
                    <smal class="font-medium text-gray-900 dark:text-white mx-2 my-2">
                        Sistema para auxiliar fluxo de trabalho!
                    </smal>
               
            </div>
            <div>
                <Carousel />
            </div>
            

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Bem Vindo! aqui suas idéias são bem vindas...
            </h1>

            <p class="mt-6 text-gray-500 leading-relaxed">
                Dentro do nosso sistema você consegue inumeras informmações como por exemplo:<br>
                -> Visualizar contracheque <br>
                -> Enviar SMS em massa <br>
                -> Sistema de auxilio do Administrativo Financeiro <br>
                -> Link's de acesso a sistemas, centralizando acessos <br>
            </p>
        </div>
        <Footer />
    </div>
</template>
