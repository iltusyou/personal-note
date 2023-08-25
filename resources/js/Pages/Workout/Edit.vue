<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue'
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import axios from "axios";

const record_date = ref(null)
const weight = ref(0);

const handleSave = async () => {
    try {
        const data = {
            record_date: record_date.value,
            weight: weight.value
        };

        const req = await axios.post('/workout/store', data);
        if (req.data.message) {
            alert(req.data.message)
        }
        else {
            alert('success');
        }
    } catch (e) {
        console.log(e);
    }
}

defineProps({
    id: Number
});

onMounted(() => {
    
});

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                重訓紀錄 {{ id }} {{ weight }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
                            <div>
                                <DatePicker v-model:value="record_date" value-type="date"></DatePicker>
                                <input class="ml-4" type="text" placeholder="體重" v-model="weight">
                                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded ml-4"
                                    @click="handleSave">save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
