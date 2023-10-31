<script>

import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';



export default {
    components: {
    AppLayout,
    FormSection,
    InputError,
    InputLabel,
    PrimaryButton,
    TextInput,
    Swal,    
    },
    
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                arquivo: '',
                description: '',
            }),
        };
    },
    methods: {
        fileChanged(event) {
            this.file = event.target.files[0]
        },
        createUser: async function () {
            let formData = new FormData()

            formData.append('file', this.file)
            formData.append('title', this.form.title)
            formData.append('description', this.form.description)

           const config = { headers: { 'Content-Type': 'multipart/form-data' } };
           await axios.post('/api/payment/store', formData, config)
            .then(
                alert("Este processo demora em torno de 45 segundo... favor aguardar")
                )
            .then(response => {
                console.log(response.status);
                if(response.data.status == true){
                    this.$swal("Sucesso", response.data.message, "success");
                        setTimeout(() => {
                            this.$inertia.visit("/payments");
                        }, 200);
                }               
            })
            .catch(err => () => this.$swal("Erro", err.data.message, "error")
                //console.log(err.data)
                );
        },
        
    },   
};




</script>

<template>
    <AppLayout title="Importar pagamentos">
        <template #header>
            <div class="flex justify-between">
                    <div class="">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Adicionar pagamentos XML
                        </h2>
                    </div>
                    <div class="">
                        <a href="/payments">
                            <button class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded align-middle">
                                Voltar
                            </button>
                        </a>
                    </div>
                </div>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <FormSection  @submitted="createUser" >
                        <template #title>
                            Detalhes da importação
                        </template>

                        <template #description>
                            Para importar o arquivo  é preciso seguir os seguintes requisitos:<br>
                            
                            -> Layout padrão de importacao XML, definido e padronizado junto a contadora<br>
                            

                            
                        </template>

                        <template #form>
                            <div class="col-span-4 sm:col-span-2">
                                <InputLabel for="title" value="Nome" />
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="block w-full mt-1"
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <InputLabel for="arquivo" value="Arquivo" />
                                <TextInput
                                    id="arquivo"
                                    v-model="form.arquivo"
                                    type="file"
                                    class="block w-full mt-1"
                                    @change="fileChanged"
                                />
                                <InputError :message="form.errors.arquivo" class="mt-2" />
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <InputLabel for="description" value="Descrição" />
                                <TextInput
                                    id="description"
                                    v-model="form.description"
                                    type="text"
                                    class="block w-full mt-1"
                                />
                                <InputError :message="form.errors.description" class="mt-2" />
                            </div>                            
                        </template>
                        <template #actions>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Adicionar
                            </PrimaryButton>
                        </template>
                    </FormSection>
            </div>
        </div>
    </AppLayout>
</template>
