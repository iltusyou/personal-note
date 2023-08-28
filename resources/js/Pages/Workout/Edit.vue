
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                重訓紀錄 {{ recordDate }}
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
                            <hr class="my-2 h-0.5" />
                            <div v-for="(item, idx) in weightTrainings">
                                <TrainingVolume :index="idx" :weightTrainingOptions="weightTrainingOptions"
                                    :weightTraining="item" @update:weightTrainingName="updateWeightTrainingName"
                                    @update:load="updateLoad" @update:repetitions="updateRepetitions"
                                    @add:trainingVolume="addTrainingVolume" @delete:trainingVolume="deleteTrainingVolume">
                                </TrainingVolume>
                                <hr class="my-2 h-0.5" />
                            </div>

                            <div>
                                <button type="button" class="bg-green-500 text-white px-4 py-2 rounded"
                                    @click="addWeightTraining">新增重訓類別</button>
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
        const recordDate = ref(null)
        const weight = ref(0);

        const weightTraining = ref({
            name: '',
            trainingVolumes: [{
                load: 0,
                repetitions: 0
            }]
        });

        const weightTrainings = ref([]);

        const weightTrainingOptions = ref([]);

        const handleRecordDate = () => {
            let urlParams = new URLSearchParams(window.location.search);
            let dateString = urlParams.get('date');
            const date = Moment(dateString).toDate();
            recordDate.value = date;

            console.log(date);
            getRecord(dateString);
        }

        const getRecord = async (date) => {
            const req = await axios.get('/workout/getRecord/' + date);
            if (req.data.message) {
                return alert(req.data.message)
            }
            console.log(req.data.data);
            const data = req.data.data;

            if (data) {
                weight.value = data.weight;
                weightTrainings.value = data.weight_training_records.map(function (item) {
                    return {
                        name: item.weight_training_id,
                        trainingVolumes: item.training_volumns.map(function (e) {
                            return {
                                load: e.load,
                                repetitions: e.repetitions
                            }
                        })
                    };
                });
            }
        }

        const addWeightTraining = () => {
            weightTrainings.value.push({
                name: '',
                trainingVolumes: [{
                    load: 0,
                    repetitions: 0
                }]
            })
        }

        const handleWeightTrainingOptions = async () => {

            const req = await axios.get('/workout/getWeightTrainings');
            if (req.data.message) {
                return alert(req.data.message)
            }
            console.log(req.data.data);

            weightTrainingOptions.value = req.data.data.map(function (e) {
                return {
                    text: `${e.name}(預設:${e.default_weight})`,
                    value: e.id
                }
            });
        }

        const addTrainingVolume = (index, newItem) => {
            weightTrainings.value[index].trainingVolumes.push(newItem);
        }

        const deleteTrainingVolume = (index, idx) => {
            weightTrainings.value[index].trainingVolumes.splice(idx, 1);
        }

        const updateWeightTrainingName = (selected, index) => {
            weightTrainings.value[index].name = selected;
        }

        const updateLoad = (input, index, i) => {
            weightTrainings.value[index].trainingVolumes[i].load = input;
        }

        const updateRepetitions = (input, index, i) => {
            weightTrainings.value[index].trainingVolumes[i].repetitions = input;
        }

        const handleSave = async () => {
            const data = {
                recordDate: recordDate.value,
                weight: weight.value,
                weightTrainings: weightTrainings.value
            };

            const req = await axios.post('/workout/store', data);
        }

        onMounted(() => {
            handleRecordDate();
            handleWeightTrainingOptions();
        });

        return {
            recordDate,
            weight,
            weightTrainings,
            weightTrainingOptions,

            handleWeightTrainingOptions,
            addWeightTraining,
            handleSave,

            updateWeightTrainingName,
            updateLoad,
            updateRepetitions,
            addTrainingVolume,
            deleteTrainingVolume
        }
    }
}
</script>

