<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
</script>

<template>
    <!-- Settings Dropdown -->
    <div class="ml-3 relative">
        <Dropdown align="right" width="48">
            <template #trigger>
                <button  class="inline-flex items-center mt-5 px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                    Whats Corp.
                </button>
            </template>

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Links WhatsApp DMA
                </div>

                <DropdownLink as="blank" :href="'https://sicoob.dunice.com.br/'" >
                    SICOOB
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://backoffice.dunice.com.br/'" >
                    BackOffice
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://controladoria.dunice.com.br/'" >
                    Controladoria
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://itapeva.dunice.com.br/'" >
                    Itapeva
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://safraw.dunice.net.br/'" >
                    Safra
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://bradesco.dunice.com.br/'" >
                    Bradesco
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://retomadas.dunice.com.br/'" >
                    Retomadas
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://posretomadas.dunice.com.br/'" >
                    Pós Retomadas
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://juridico1.dunice.com.br/'" >
                    juridico1
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://juridico3.dunice.com.br/'" >
                    juridico3
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://retpeva.dunice.net.br'" >
                    Ret. Itapeva
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://retdiv.dunice.net.br'" >
                    Ret. Divzero
                </DropdownLink>
            </template>
        </Dropdown>
    </div>
</template>