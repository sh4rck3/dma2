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
                    Jurídico
                </button>

                
            </template>

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Links Juridico
                </div>

                <DropdownLink as="blank" :href="'https://safrajuridico.safra.com.br/Login?ReturnUrl=%2fJuridico%3fi%3dJURIDICO%26m%3dMAIN&i=JURIDICO&m=MAIN'" >
                    Benner
                </DropdownLink>
                <DropdownLink as="blank" :href="'http://caixago.dunice.srv.br/'" >
                    Caixa GO
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://www.dponet.com.br/?utm_source=google&utm_medium=cpc&utm_campaign=responsivo+institucional+ad01+copy01&utm_content=home+institucional&gclid=Cj0KCQjwu-KiBhCsARIsAPztUF0rJc3eBnV9UEcA2RWgBnQm0qdfUGuNo0qHHLC8T-EgtJ1BQp8aAyMaAkwREALw_wcB'" >
                    DPO NET
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://captcha.bradesco.com.br/wcap/acesso.jsp?destinationLink=https://portaldsps.bradesco.com.br/psds/'" >
                    DSPS
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://juridico8.bradesco.com.br/gcpj/'" >
                    GCPJ
                </DropdownLink>
                <DropdownLink as="blank" :href="'http://www.lcrbrasil.com.br/'" >
                    LCR Brasil
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://www.looplex.com.br/'" >
                    Looplex
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://pjd.tjgo.jus.br/'" >
                    PJD GO
                </DropdownLink>
                <DropdownLink as="blank" :href="'https://filetransfer.bradesco.b.br/wtcdfiletransfer/entrada.do'" >
                    WebTA
                </DropdownLink>
            </template>
        </Dropdown>
    </div>
</template>