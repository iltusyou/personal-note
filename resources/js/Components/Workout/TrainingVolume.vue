<template>
    <div>
        <div class="mt-4">
            <label>重訓類別</label>
            <select :value="weightTraining.name" @change="updateWeightTrainingName($event)" class="ml-4">
                <option v-for="(val, idx) in weightTrainingOptions" :value="val.value">{{ val.text }}</option>
            </select>
            <div v-for="(val, idx) in weightTraining.trainingVolumes" class="mt-4">
                <input type="text" placeholder="負重" :value="val.load"
                    @input="updateLoad($event, idx)">
                <input type="text" placeholder="次數" class="ml-4" :value="val.repetitions"
                    @input="updateRepetitions($event, idx)">
                <button type="button"
                    class="bg-red-500 ml-4 inline-block rounded bg-primary px-2 pb-1 pt-1 text-xs font-medium uppercase leading-normal text-white "
                    @click="deleteTrainingVolume(idx)">
                    remove
                </button>
                <button type="button"
                    class="bg-green-500 ml-2 inline-block rounded bg-primary px-2 pb-1 pt-1 text-xs font-medium uppercase leading-normal text-white"
                    v-if="idx==weightTraining.trainingVolumes.length-1"
                    @click="addTrainingVolume">
                    add
                </button>
            </div>            
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
const props = defineProps({
    index: Number,
    weightTrainingOptions: Array,
    weightTraining: Object
})
const emit = defineEmits([
    'update:weightTraining',
    'update:load',
    'update:repetitions',
    'add:trainingVolume',
    'delete:trainingVolume'
])

const addTrainingVolume = () => {
    const newItem = {
        load: 0,
        repetitions: 0
    };
    emit('add:trainingVolume', props.index, newItem);
}

const deleteTrainingVolume=(idx)=>{
    emit('delete:trainingVolume', props.index, idx);
}

const updateWeightTrainingName = (e) => {
    emit('update:weightTrainingName', e.target.value, props.index)
}

const updateLoad = (e, idx) => {
    emit('update:load', e.target.value, props.index, idx)
}

const updateRepetitions = (e,idx)=>{
    emit('update:repetitions', e.target.value, props.index, idx)
}
// const showDetail = ref(true);


</script>