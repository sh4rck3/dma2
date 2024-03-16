<script setup>
import Icon from '@/Icons/Icon.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';
import { onMounted, ref, inject, computed, watch, reactive } from 'vue';
import { usePage } from '@inertiajs/vue3';
import useContacts from '@/composables/chat';
import { FwbTab, FwbTabs } from 'flowbite-vue';
import moment from 'moment';


const { contacts, messages, userActive, getContacts, loadMessages, sendMessage, message } = useContacts()
const activeTab = ref('Inbox')

const page = usePage()
const pagePermission = computed(() => page.props.user.permissions)
const swal = inject('$swal')




function showAlert() {
    swal({
        icon: 'success',
        title: 'Category saved successfully'
    })
}



onMounted(() => {
   getContacts()
   //console.log(contacts)
})



</script>
<style>
.messageFromMe {
  @apply bg-indigo-300 bg-opacity-25;
}

.messageToMe {
  @apply bg-gray-300 bg-opacity-25;
}
</style>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                    <Icon name="laravel" class="h-10 w-10 mx-2" />
                    <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                       WhatsApp
                    </h1>
            </div>
            <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                <div class="card-body shadow-sm">
                  <div class="bg-gray-50 overflow-hidden shadow-xl sm:rounded-lg flex" style="min-height: 400px; max-height: 600px;">
                        <!-- tab list users -->
                        <div class="w-5/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll">
                            <fwb-tabs v-model="activeTab" class="p-5">
                                <fwb-tab name="Inbox" title="Inbox">
                                    <!-- list users -->
                                    <ul>
                                        <li v-if="contacts.data && contacts.data.length > 0"
                                            @click="() => {loadMessages(post.id)}"
                                            v-for="post in contacts.data" :key="post.id"
                                            :class="(userActive && userActive.id == post.id) ? 'bg-opacity-50 bg-gray-200' : ''"
                                            class="p-6 text-lg text-gray-600 leading-7 font-semibold border-b border-gray-200 hover:g-gray-200 hover:bg-opacity-50 hover:cursor-pointer">
                                            <p class="flex items-center">
                                                {{ post.id }}
                                                -
                                                {{ post.name }}
                                                <span class="ml-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                                            </p>
                                        </li>
                                        <li v-else
                                            class="p-6 text-lg text-gray-600 leading-7 font-semibold border-b border-gray-200 hover:g-gray-200 hover:bg-opacity-50 hover:cursor-pointer">
                                            <p class="flex items-center">
                                                Sem Tickets selecionado
                                            </p>
                                        </li>
                                    </ul>
                                    <!--end  list users -->
                                </fwb-tab>
                                <fwb-tab name="Aguardando" title="Aguardando">
                                    <li
                                        class="p-6 text-lg text-gray-600 leading-7 font-semibold border-b border-gray-200 hover:g-gray-200 hover:bg-opacity-50 hover:cursor-pointer">
                                        <p class="flex items-center">
                                            Sem Tickets selecionado
                                        </p>
                                    </li>
                                </fwb-tab>
                            </fwb-tabs>
                        </div>
                        <!-- box message -->
                        <div class="w-7/12 flex flex-col justify-between">
                            <!-- message -->
                            <div class="w-full p-6 flex flex-col overflow-y-scroll">
                                <div
                                    v-if="messages.data && messages.data.length > 0" 
                                    v-for="post in messages.data" :key="post.id"
                                    :class="(post.from_me == 1) ? 'text-right' : ''"
                                    class="w-full mb-3">
                                    <p 
                                        :class="(post.from_me == 1) ? 'messageFromMe' : 'messageToMe'"
                                        class="inline-block p-2 rounded-md" style="max-width: 75%;">
                                        {{ post.body }} 
                                        <span class="block mt-1">{{ moment(post.created_at).format('DD/MM/YYYY HH:mm') }}</span>
                                    </p>
                                </div>
                                <div
                                    v-else 
                                    class="w-full mb-3">
                                    <p class="inline-block p-2 rounded-md messageToMe" style="max-width: 75%;">
                                        Selecione um ticket!
                                        <span class="block mt-1">Date</span>
                                    </p>
                                </div>
                            </div>
                            <!-- form -->
                            <div 
                                v-if="userActive"
                                class="w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200">
                                <form v-on:submit.prevent="sendMessage">
                                    <div class="flex rounded-md overflow-hidden border border-gray-300">
                                        <input v-model="message" type="text" class="flex-1 px-4 py-2 text-sm focus:outline-none">
                                        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2">Enviar</button>
                                    </div>
                                </form>
                            </div>  
                        </div>
                  </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>
