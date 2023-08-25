<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { format } from "date-fns";

const records = ref([])

const handleRecords = async () => {
    try {
        const req = await axios.post('/workout/getRecords');
        records.value = req.data.data;
        console.log(req.data.data);
    } catch (e) {

    }
}

const dateFormat = (date) => {
    return format(date);
}


onMounted(() => {
    handleRecords();
});



</script>

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
                    <div>
                        <Link :href="route('workout.edit')" :class="classes">
                        新增
                        </Link>
                    </div>

                    <div>
                        <table>
                            <tr v-for="(val, idx) in records" :key="idx">
                                <td>{{ val.record_date }}</td>
                                <td>
                                    <a :href="'/workout/edit/' + val.id"
                                        class="bg-blue-500 text-white px-4 py-2 rounded ml-4">Edit</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
