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
                    Cobrança
                </button>

                
            </template>

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Links Cobrança
                </div>

                <DropdownLink as="blank" :href="'https://duniceemarcon.cloudnexcore.com.br/ncall/main.php?inicio=1'" >
                    Nexcore
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://buscacepinter.correios.com.br/app/endereco/index.php'" >
                    Busca CEP
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://172.23.1.121/'" >
                    Telefonia DMA
                </DropdownLink>
                <DropdownLink as="blank" :href="'http://cyb0020.cobcyss.com.br:30080/gecobi2/frontend/public/#/login?toPath=%2Fhome'" >
                    CPJ Cobrança
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://intouch.unitfour.com.br/'" >
                    Intouch
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://scdnetweb.safra.com.br/login2.aspx'" >
                    J Safra
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://wwws.jsafra.com.br/FinanceiraVeiculos/LoginForm?ReturnUrl=%2ffinanceiraveiculos'" >
                    Safra Financeira
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://lemitti.com/home'" >
                    Lemit
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://molicar.com.br/'" >
                    Molicar
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://veiculos.fipe.org.br/'" >
                    Tabela FIPE
                </DropdownLink>
            </template>
        </Dropdown>
    </div>
</template>