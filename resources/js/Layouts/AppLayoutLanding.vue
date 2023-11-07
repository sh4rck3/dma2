<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import NavLink from '@/Components/NavLink.vue';
import Icon from '@/Icons/Icon.vue';
import Darkmode from '@/Components/Darkmode.vue';
import Linkblank from '@/Components/Linkblank.vue';
import Dropdowncob  from '@/Components/Dropdowncob.vue';
import Dropdownjur from '@/Components/Dropdownjur.vue';
import Dropdowndp from '@/Components/Dropdowndp.vue';
import Dropdownwhats from '@/Components/Dropdownwhats.vue';
 

import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';


// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
});


defineProps({
    title: String,
    glpiLink: String,
    nameLink: String,
});

const glpiLink = ref('https://glpi.dunice.com.br')
const nameLink = ref('Chamados')

</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <Icon name="laravel" class="w-10 h-10" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                                <NavLink :href="route('home')" :active="route().current('home')">
                                    Home
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                                <NavLink :href="route('extensions')" :active="route().current('extensions')">
                                    Ramais
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                                <NavLink :href="route('smssend')" :active="route().current('smssend')">
                                    SMS
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                                <Linkblank :href="glpiLink">
                                    {{ nameLink }}
                                </Linkblank>
                            </div>
                            <Dropdowncob />
                            <Dropdownjur />
                            <Dropdowndp />
                            <Dropdownwhats />
                            <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                                <NavLink :href="route('birthday')" :active="route().current('birthday')">
                                    Aniversariantes
                                </NavLink>
                            </div>
                            <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                                <a 
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out"
                                href="/storage/uploads/REGULAMENTO_INTERNO_TRABALHISTA_DISCIPLINAR -DUNICE.pdf" target="_blank" >
                                    Regimento Interno
                                </a>
                            </div>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="flex justify-center p-4">
                                <Darkmode class="mx-2 mt-3" />
                                <a :href="route('login')">
                                    <button  
                                        type="button" 
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Entrar
                                    </button> 
                                </a>                    
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
       
    </div>
</template>
