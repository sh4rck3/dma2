<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { FwbInput, FwbSelect } from 'flowbite-vue';
import useRoles from '../../../../composables/roles';

const { roleList, getRoleList } = useRoles();

const name = ref('');
const email = ref('');
const role = ref('');
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
            name.value = response.data.data.name;
            email.value = response.data.data.email;
            role.value = response.data.data.roles[0].name;
            //selected.value = response.data.data.roles[0].name;
            //console.log(response.data.data.roles[0].name);
            //console.log(selected.value);
        })
        .catch(error => {
            console.log(error);
        }),
    getRoleList()
});

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
                    <FwbInput v-model="name" label="Nome" size="sm" disabled />
                    <FwbInput v-model="email" label="Email" size="sm" disabled />
                    <FwbSelect
                        v-model="selected"
                        :options="roleList"
                        label="Permissões"
                        size="sm"
                    />
                </div>
                
            </div>
            
        </div>
        <Footer />
    </div>
</template>
