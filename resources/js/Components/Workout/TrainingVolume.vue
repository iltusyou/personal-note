<template>
    <div>
        <!-- <div>
            <button type="button"
                class="bg-red-500 w-50 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                @click="$emit('delete:trainingVolume')">
                {{weightTraining.name||'選擇重訓類別'}}
            </button>
        </div> -->

        <div class="mt-4">
            <label>重訓類別</label>
            <select :value="weightTraining.name" @change="$emit('update:weightTraining', $event.target.value)" class="ml-4">
                <option v-for="(val, idx) in weightTrainingOptions" :value="val.value">{{ val.text }}</option>
            </select>
            <div v-for="(val, idx) in weightTraining.trainingVolumes" class="mt-4">
                <input type="text" placeholder="負重" :value="val.load"
                    @input="$emit('update:load', $event.target.value, idx)">
                <input type="text" placeholder="次數" class="ml-4" :value="val.repetitions"
                    @input="$emit('update:repetitions', $event.target.value)">
                <button type="button"
                    class="bg-red-500 ml-4 inline-block rounded bg-primary px-2 pb-1 pt-1 text-xs font-medium uppercase leading-normal text-white "
                    @click="$emit('delete:trainingVolume')">
                    remove
                </button>
            </div>
            <div>
                <button type="button"
                    class="bg-green-500 mt-4 inline-block rounded bg-primary px-2 pb-1 pt-1 text-xs font-medium uppercase leading-normal text-white"
                    @click="$emit('add:trainingVolume')">
                    add
                </button>
            </div>
        </div>


    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
const props = defineProps({
    weightTrainingOptions: Array,
    weightTraining: Object
})
defineEmits([
    'update:weightTraining',
    'update:load',
    'update:repetitions',
    'add:trainingVolume',
    'delete:trainingVolume'
])

const showDetail = ref(true);



</script>