<script setup>
import Footer from '@/Components/Landings/Partials/Footer.vue';
import { FwbInput, FwbButton } from 'flowbite-vue';
import { ref, reactive } from 'vue';

const form = reactive({
  first_name: null,
  last_name: null,
  email: null,
})


const name = ref('')

function submit(){
    console.log(form)
    //console.log('o nome escrito e: ' + this.name)
}

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
            SMS fica aqui
            <form @submit.prevent="submit" class="ml-20">
                
                <fwb-input
                    class="" 
                    id="first_name" 
                    v-model="form.first_name" 
                    label="First Name"
                    />
                <label for="last_name">Last name:</label>
                <input id="last_name" v-model="form.last_name" />
                <label for="email">Email:</label>
                <input id="email" v-model="form.email" />
                <button type="submit">Submit</button>
            </form>
        </div>
        <Footer />
    </div>
</template>
