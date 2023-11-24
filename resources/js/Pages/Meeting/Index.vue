<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const pageRole = computed(() => page.props.user.roles)


</script>
<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list'

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data() {
    return {
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
      alert('date click! ' + arg.dateStr)
    },
    handleEventClick(clickInfo) {
      if (confirm(`Are you sure you want to delete the event '${clickInfo.event.title}'`)) {
        clickInfo.event.remove()
      }
    },
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

    