<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';


</script>
<script>
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import Footer from '@/Components/Landings/Partials/Footer.vue';



export default {
    components: {
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
        importRemessa: async function () {
            let formData = new FormData()

            formData.append('file', this.file)
            formData.append('title', this.form.title)
            formData.append('description', this.form.description)

           const config = { headers: { 'Content-Type': 'multipart/form-data' } };
           await axios.post('/api/financial/store', formData, config)
            .then(
                alert("Este processo demora em torno de 45 segundo... favor aguardar")
                )
            .then(response => {
                console.log(response.status);
                if(response.data.status == true){
                    console.log(response.data.returnData);
                    this.$swal(response.data.title, response.data.message, "success");
                        setTimeout(() => {
                            this.$inertia.visit("/financial");
                        }, 200);
                }               
            })
            .catch(err => () => this.$swal("Erro", err.data.message, "error")
                //console.log(err.data)
                );
        },
        deleteRemessa(){
            console.log(this.form.idRemessa)
        }        
    },   
};
</script>

<template>
    <AppLayout title="Painel">
        <template #header>
            <div class="flex justify-between">
                <div class="">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Adicionar remessa Excel
                    </h2>
                </div>
                <div class="">
                    <a href="/financial">
                        <button class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded align-middle">
                            Voltar
                        </button>
                    </a>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <FormSection  @submitted="importRemessa" >
                        <template #title>
                            Detalhes da importação
                        </template>

                        <template #description class="ms-8">
                            Para importar o arquivo  é preciso seguir os seguintes requisitos:<br>
                            
                            -> Layout padrão de importacao e na mesma ordem de sempre<br>
                            as colunas,como definido e padronizado anteriormente.<br>
                            -> O arquivo deve ser no formato .xls ou .xlsx<br>
                            para facilitar a importação.<br>
                            OBSERVAçÂO: O arquivo deve ser salvo no formato .xlsx<br>
                            Para baixar o layout padrão de importação clique no link abaixo:<br>
                            Remova a primeira linha do arquivo e salve no formato .xlsx<br>
                            <a href="/storage/uploads/ModeloDeArquivoParaImportacao.xlsx">Baixar Layout</a>
                            

                            
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
                    <FormSection  @submitted="deleteRemessa">
                        <template #form>
                            <div class="col-span-4 sm:col-span-2">
                                <InputLabel for="idRemessa" value="Deletar" />
                                <TextInput
                                    id="idRemessa"
                                    v-model="form.idRemessa"
                                    type="text"
                                    class="block w-full mt-1"
                                />
                                <InputError :message="form.errors.idRemessa" class="mt-2" />
                            </div>
                        </template>
                        <template #actions>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Deletar
                            </PrimaryButton>
                        </template>
                    </FormSection>

                    <slot />
                    <Footer />
                </div>
            </div>
        </div>
    </AppLayout>
</template>