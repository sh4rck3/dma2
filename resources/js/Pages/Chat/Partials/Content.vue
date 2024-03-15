<script setup>
import Icon from '@/Icons/Icon.vue';
import Footer from '@/Components/Landings/Partials/Footer.vue';
import { onMounted, ref, inject, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import useContacts from '@/composables/chat';

const { contacts, messages, getContacts, loadMessages } = useContacts()

const page = usePage()
const pagePermission = computed(() => page.props.user.permissions)
const swal = inject('$swal')
const apiusers = ref([])


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
                        <!-- list users -->
                        <div class="w-5/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll">
                                <ul>
                                    <li v-if="contacts.data && contacts.data.length > 0"
                                        @click="() => {loadMessages(post.id)}"
                                        v-for="post in contacts.data" :key="post.id"
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
                        </div>
                        <!-- box message -->
                        <div class="w-7/12 flex flex-col justify-between">
                            <!-- message -->
                            <div class="w-full p-6 flex flex-col overflow-y-scroll">
                                <div class="w-full mb-3 text-right">
                                    <p class="inline-block p-2 rounded-md messageFromMe" style="max-width: 75%;">
                                        Olá
                                        <span class="block mt-1">15/03/2024 09:52</span>
                                    </p>
                                </div>
                                <div class="w-full mb-3">
                                    <p class="inline-block p-2 rounded-md messageToMe" style="max-width: 75%;">
                                        oi
                                        <span class="block mt-1">15/03/2024 09:53</span>
                                    </p>
                                </div>
                            </div>
                            <!-- form -->
                            <div class="w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200">
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
