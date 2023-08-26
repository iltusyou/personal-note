<template>
    <div>
        <select :value="weightTraining.name" @change="$emit('update:weightTraining', $event.target.value)">
            <option v-for="(val, index) in weightTrainingOptions" :value="val.value">{{ val.text }}</option>
        </select>
        <div v-for="(val,idx) in weightTraining.trainingVolume">
            <input type="text" :value="val.load" @input="$emit('update:load', $event.target.value)">
            <input type="text" :value="val.repetitions" @input="$emit('update:repetitions', $event.target.value)">
        </div>        
    </div>
</template>

<script setup>
const props = defineProps({
    weightTrainingOptions: Array,
    weightTraining: Object
})
defineEmits(['update:weightTraining','update:load','update:repetitions'])

</script>