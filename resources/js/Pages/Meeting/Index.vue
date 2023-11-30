<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';


</script>
<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'
import moment from 'moment'
import { FwbButton, FwbModal, FwbInput, FwbTextarea, FwbSelect } from 'flowbite-vue'

import { computed, inject, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const isShowModal = ref(false)
const selected = ref('')
const toast = inject('$toast')
const swal = inject('$swal')

const page = usePage()
const pageRole = computed(() => page.props.user.roles)

const localeMeeting = [
  { value: 'us', name: 'Sala1' },
  { value: 'ca', name: 'Sala2' },
  { value: 'fr', name: 'Sala3' },
]

function closeModal () {
    isShowModal.value = false
    }
    function showModal () {
    isShowModal.value = true
    }
export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
    
  },
  data() {
    return {
        dateMeeting: String,
        dateMeeting2: String,
        timeMeeting: '',
        subject: '',
        linkMeeting: '',
        observation: '',
        localeMeeting: '',
        formData: Object,

      calendarOptions: {
        locale: 'pt-br',
        plugins: [ 
            dayGridPlugin,
            timeGridPlugin,
            listPlugin, 
            interactionPlugin ],
        headerToolbar: {
          left: 'prev,today,next',
          center: 'title',
          right: 'dayGridMonth,listMonth'
        },
        initialView: 'dayGridMonth',
        select: this.handleDateSelect,
        weekends: false,
        dateClick: this.handleDateClick,
        events: [
          { title: 'event 1', date: '2023-11-24' },
          { title: 'event 2', date: '2023-11-27' }
        ]
      }
    }
  },
  methods: {
    handleDateClick: function(arg) {
      //this.clearFormData()
      const dateFormat = date => moment(date).format('DD/MM/YYYY')
      console.log(dateFormat(arg.dateStr))
      this.dateMeeting2 = dateFormat(arg.dateStr)
      this.dateMeeting = arg.dateStr
      showModal()    
    },
    handleEventClick(clickInfo) {
      if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
        clickInfo.event.remove()
      }
    },
    onSubmit() {
        this.formData = {
            dateMeeting: this.dateMeeting,
            timeMeeting: this.timeMeeting,
            subject: this.subject,
            linkMeeting: this.linkMeeting,
            localeMeeting: this.selected,
            observation: this.observation
        }
        axios.post('/api/meeting/store', this.formData)
        .then(response => {
            this.$swal({
                title: response.data.title,
                text: response.data.message,
                icon: response.data.icon
                    })
            

        })
        .catch(error => {
            this.$swal({
                        icon: 'error',
                        title: 'Meeting nao foi salva!'
                    })
        })
        closeModal()
        this.$refs.modalFormData.reset()
    },
    clearFormData() {

        this.dateMeeting = '',
        this.timeMeeting = '',
        this.subject = '',
        this.linkMeeting = '',
        this.selected = '',
        this.observation = ''
    }
    
  }
}
</script>

<template>
    <AppLayout title="Usuários">
        <template #header>
            <div class="flex justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Reniões
                    </h2>
                </div>
                
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg text-gray-400">
                    <h1>Agenda de reniões Dunice Marcon</h1><br>
                    
                    <FullCalendar :options='calendarOptions'>
                       
                    </FullCalendar>
                    
                    <fwb-modal v-if="isShowModal" @close="closeModal" ref="modalFormData">
                        <template #header>
                        <div class="flex items-center text-lg">
                            Informações da reunião: {{ dateMeeting2 }}
                        </div>
                        </template>
                        <template #body>
                          <form @submit.prevent="onSubmit" id="formData">
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                
                                <fwb-input
                                    v-model="subject"
                                    placeholder="Ex: Reunião PJE - Cívil"
                                    label="Assunto da reunião"
                                />
                                <fwb-textarea
                                    v-model="linkMeeting"
                                    :rows="4"
                                    label="Link da reunião"
                                    placeholder="Links começam com https://teams...... ou https://meet.google.com/...."
                                />
                            <div class="flex">
                                    <fwb-input
                                        v-model="dateMeeting"
                                        type="date"
                                        label="Data"
                                        disabled
                                    />
                                    <fwb-input
                                        v-model="timeMeeting"
                                        type="time"
                                        label="Hora"
                                        
                                    />
                                    <fwb-select
                                        v-model="selected"
                                        :options="localeMeeting"
                                        label="Selecione o local"
                                    />
                            </div>
                                <fwb-textarea
                                    v-model="observation"
                                    :rows="4"
                                    label="Observações"
                                    placeholder="Mais informações sobre a reunião"
                                />
                            </p>
                            <fwb-button type="submit" color="green">
                            Agendar Renião
                            </fwb-button>
                          </form>
                        </template>
                        <template #footer>
                        <div class="flex justify-between">
                           <p>Obs: As reuniões agendads, so serão acompanhadas se foram agendadas pelo sistema, serão descartados quaisquer outros meios.</p>                           
                        </div>
                        </template>
                    </fwb-modal> 
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style>
:root {
  --fc-border-color: grey;
  --fc-daygrid-event-dot-width: 5px;
}


h2 {
  margin: 0;
  font-size: 16px;
}

ul {
  margin: 0;
  padding: 0 0 0 1.5em;
}

li {
  margin: 1.5em 0;
  padding: 0;
}

b { /* used for event dates/times */
  margin-right: 3px;
}

.demo-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

.demo-app-sidebar {
  width: 300px;
  line-height: 1.5;
  background: #eaf9ff;
  border-right: 1px solid #d3e2e8;
}

.demo-app-sidebar-section {
  padding: 2em;
}

.demo-app-main {
  flex-grow: 1;
  padding: 3em;
}

.fc { /* the calendar root */
  max-width: 1100px;
  margin: 0 auto;
}

</style>

    