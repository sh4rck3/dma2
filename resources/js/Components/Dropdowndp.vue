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
                    Depart. Pessoal
                </button>

                
            </template>

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Links do DP
                </div>

                <DropdownLink as="blank" :href="'https://portal.ciee.org.br/'" >
                    CIEE
                </DropdownLink>
                <DropdownLink as="blank" :href="'http://www.lignetsafra.com.br/'" >
                    Lignet Safra
                </DropdownLink>
            </template>
        </Dropdown>
    </div>
</template>