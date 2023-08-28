<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <FullCalendar :options="calendarOptions" :events="currentEvents">
                        <template v-slot:eventContent='arg'>
                            <b>{{ arg.timeText }}</b>
                            <i>{{ arg.event.title }}</i>
                        </template>
                    </FullCalendar>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from "axios";
import Moment from 'moment';
import AppLayout from '@/Layouts/AppLayout.vue';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    components: {
        AppLayout,
        FullCalendar
    },

    setup() {

        const handleDateClick = (arg) => {
            const url = '/workout/edit?date=' + arg.dateStr;
            window.location.href = url;
        }

        const handleEventClick = (clickInfo) => {               
            const dateString = clickInfo.event.start;
            const date = Moment(dateString).format('YYYY-MM-DD');
            const url = '/workout/edit?date=' + date;
            window.location.href = url;
        }

        onMounted(() => {
            
        });

        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'dayGridMonth',
                dateClick: handleDateClick,
                editable: true,
                events: '/workout/getRecords',
                eventClick: handleEventClick
            }      
        }
    }
}
</script>