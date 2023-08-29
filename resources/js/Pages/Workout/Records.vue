<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                重訓紀錄
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="py-4 px-6">
                        <div class="mt-4">
                            <label>重訓類別</label>
                            <select class="ml-4" v-model="selected" @change="handleOptionChange">
                                <option value="" selected>All</option>
                                <option v-for="(val, idx) in weightTrainingOptions" :value="val.value">{{ val.text }}
                                </option>
                            </select>
                        </div>

                        <div class="mt-8">
                            <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                <thead class="border-b font-medium dark:border-neutral-500">
                                    <tr>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            #
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            日期
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            重訊名稱
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            訓練量(負重 x 次數)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b dark:border-neutral-500" v-for="(val, idx) in showRecords"
                                        :key="idx">
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                            {{ (Number(idx) + 1) }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                            {{ dateFormat(val.date) }}
                                        </td>
                                        <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                            {{ val.name }}
                                        </td>
                                        <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                            {{ trainingVolumnsFormat(val.trainingVolumns) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';

import Moment from 'moment';

export default {
    components: {
        AppLayout
    },
    setup() {

        const selected = ref("");
        const records = ref([]);
        const showRecords = ref([]);

        const weightTrainingOptions = ref([]);

        const handleWeightTrainingOptions = async () => {

            const req = await axios.get('/workout/getWeightTrainings');
            if (req.data.message) {
                return alert(req.data.message)
            }
            console.log(req.data.data);

            weightTrainingOptions.value = req.data.data.map(function (e) {
                return {
                    text: `${e.name}`,
                    value: e.id
                }
            });
        }

        const handleOptionChange = () => {

            console.log(selected.value)
            if (selected.value) {
                showRecords.value = records.value.filter((item) => {
                    return item.weightTrainingId == selected.value;
                });
            }
            else {
                showRecords.value = records.value;
            }
        }

        const handleRecords = async () => {
            const req = await axios.get('/workoutRecords/list');
            if (req.data.message) {
                return alert(req.data.message)
            }
            const data = req.data.data;
            console.log(data);

            records.value = data;
            showRecords.value = data;
        }

        const trainingVolumnsFormat = (trainingVolumns) => {
            var arr = trainingVolumns.map(function (e) {
                return '' + e.load + ' x ' + +e.repetitions
            });

            return arr.join('|');;
        }

        const dateFormat = (dateStr) => {
            const date = Moment(dateStr).format('YYYY/MM/DD');
            return date;
        }

        onMounted(() => {
            handleWeightTrainingOptions();
            handleRecords();
        });

        return {
            records,
            showRecords,
            weightTrainingOptions,selected,

            trainingVolumnsFormat,
            dateFormat,            
            handleWeightTrainingOptions,handleOptionChange
        }
    }
}
</script>