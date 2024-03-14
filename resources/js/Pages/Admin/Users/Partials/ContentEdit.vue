<script setup>
import axios from 'axios';
import { onMounted, ref, inject } from 'vue';
import { FwbInput, FwbSelect } from 'flowbite-vue';
import useRoles from '../../../../composables/roles';
import { router } from '@inertiajs/vue3'

const { roleList, getRoleList } = useRoles();
const swal = inject('$swal');

const name = ref('');
const userId = ref('');
const email = ref('');
const role = ref('');
const roleSelect = ref('');
const selected = ref('');


const props = defineProps({
    userId: {
        type: Object,
        required: true,
    },
});



onMounted( async () => {
    
    await axios.put(`/api/useradmedit/${props.userId}`)
        .then(response => {
            userId.value = response.data.data.id;
            name.value = response.data.data.name;
            email.value = response.data.data.email;
            role.value = response.data.data.roles[0].name;
            selected.value = response.data.data.roles[0].name;
            //console.log(response.data.data.roles[0].name);
            //console.log(selected.value);
        })
        .catch(error => {
            console.log(error);
        }),
    getRoleList()
    console.log(roleList);
});

function submitForm() {
    axios.put(`/api/useradmupdate/${userId.value}`, {
        role: role.value,
    })
        .then(response => {
            swal({
            title: response.data.title,
            text: response.data.message,
            icon: response.data.icon
                }),
            router.get(route('useradm'))
        })
        .catch(error => {
            swal({
            title: response.data.title,
            text: response.data.message,
            icon: response.data.icon
                })
        })
}

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            <div class="w-screen px-4 py-5 flex justify-content align-items">
                
                    <Icon name="laravel" class="h-10 w-10 mx-2" />
                
                
                    <h1 class="ml-3 text-2xl font-medium text-gray-900 dark:text-white mx-1">
                       {{ name }} 
                    </h1>
                   
               
            </div>
            <div class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                <div class="card-body shadow-sm">
                    <form @submit.prevent="submitForm">
                        <input type="hidden" name="userId" :value="userId">
                        <FwbInput v-model="name" label="Nome" size="sm" disabled />
                        <FwbInput v-model="email" label="Email" size="sm" disabled />
                        <div>
                            <label for="roles" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Permissões
                            </label>
                            <select id="roles" v-model="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option :value="selected" selected>{{ selected }}</option>
                                <option
                                    v-for="role in roleList" :key="role.id"
                                    :value="role.name"> {{ role.name }}
                                </option>
                            </select>
                        </div>
                        <p>Regrea selecionada: {{ role }}</p>
                        <button 
                        type="submit" 
                        class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Salvar
                        </button>
                    </form>
                </div>
                
            </div>
            
        </div>
        <Footer />
    </div>
</template>
