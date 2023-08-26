
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                重訓紀錄 {{ record_date }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 gap-6 lg:gap-8 p-6 lg:p-8">
                            <div>
                                <label>體重</label>
                                <input class="ml-4" type="text" v-model="weight">
                            </div>
                            <hr class="my-2 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />
                            <div>
                                <TrainingVolume :weightTrainingOptions="weightTrainingOptions"
                                    :weightTraining="weightTraining" @update:weightTraining="updateWeightTraining"
                                    @update:load="updateLoad" @update:repetitions="updateRepetitions"
                                    @add:trainingVolume="addTrainingVolume">
                                </TrainingVolume>
                            </div>
                            <hr class="my-2 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />
                            <div>
                                <button type="button" class="bg-green-500 text-white px-4 py-2 rounded"
                                    @click="handleSave">新增重訓類別</button>
                                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded ml-4"
                                    @click="handleSave">儲存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue'
import axios from "axios";
import Moment from 'moment';
import TrainingVolume from '@/Components/Workout/TrainingVolume.vue';

export default {
    components: {
        AppLayout,
        TrainingVolume
    },

    setup() {
        const record_date = ref(null)
        const weight = ref(0);

        const weightTraining = ref({
            name: '',
            trainingVolumes: [{
                load: 0,
                repetitions: 0
            }]
        });
        const weightTrainingOptions = ref([]);        

        const handleRecordDate = () => {
            let urlParams = new URLSearchParams(window.location.search);
            let dateString = urlParams.get('date');
            const date = Moment(dateString).toDate();
            console.log(date);
            record_date.value = date;
        }

        const handleWeightTrainingOptions = () => {
            weightTrainingOptions.value = [{
                value: 1,
                text: 'aaaa'
            }, {
                value: 2,
                text: 'bbbb'
            }];
        }

        const addTrainingVolume = () => {
            weightTraining.value.trainingVolumes.push({
                load: 0,
                repetitions: 0
            });
        }

        const updateWeightTraining = (selected) => {
            weightTraining.value.name = selected;
        }

        const updateLoad = (input, index) => {
            console.log(input, index)
            weightTraining.value.trainingVolumes[index].load=input;
        }

        const updateRepetitions = (input) => {
            weightTraining.value.repetitions = input;
        }

        const handleSave = async () => {
            console.log(weightTraining.value)

            //console.log(TrainingVolume.weightTraining)

            // try {
            //     const data = {
            //         record_date: record_date.value,
            //         weight: weight.value
            //     };

            //     const req = await axios.post('/workout/store', data);
            //     if (req.data.message) {
            //         alert(req.data.message)
            //     }
            //     else {
            //         alert('success');
            //     }
            // } catch (e) {
            //     console.log(e);
            // }
        }

        onMounted(() => {
            handleRecordDate();
            handleWeightTrainingOptions();
        });

        return {
            handleSave,
            weight, record_date,
            weightTraining,
            weightTrainingOptions,
            updateWeightTraining,
            handleWeightTrainingOptions,
            updateLoad,
            updateRepetitions,
            addTrainingVolume
        }
    }
}
</script>

