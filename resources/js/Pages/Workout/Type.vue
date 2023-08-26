

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                重訓類別
            </h2>

            <div class="flex flex-col mt-4">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                                <thead class="border-b font-medium dark:border-neutral-500">
                                    <tr>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            #
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            重訊名稱
                                        </th>
                                        <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">
                                            預設重量
                                        </th>
                                        <th scope="col" class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b dark:border-neutral-500" v-for="(val, idx) in types" :key="idx">
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                            {{ idx + 1 }}
                                        </td>
                                        <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                            <input type="text" v-model="val.name">
                                        </td>
                                        <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                            <input type="text" v-model="val.default_weight">
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <button class="bg-blue-500 text-white px-2 py-2" @click="update(val.id, val.name, val.default_weight)">Save Changes</button>
                                        </td>
                                    </tr>

                                    <tr class="border-b dark:border-neutral-500">
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                        </td>
                                        <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                            <input type="text" v-model="name">
                                        </td>
                                        <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                            <input type="text" v-model="default_weight">
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <button class="bg-red-500 text-white px-2 py-2" @click="add()">Add</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue'


export default {
    components: {
        AppLayout,
    },

    setup() {
        const types = ref([]);
        const name = ref(null);
        const default_weight = ref(null);

        const handleTypes = async () => {
            const req = await axios.get('/workout/getWeightTrainings');
                if (req.data.message) {
                    return alert(req.data.message)
                }                
                console.log(req.data.data);
                types.value=req.data.data;            
        }

        const update = async(id, name, default_weight)=>{
            if (name === "") {
                return alert("Name cannot be empty");
            }

            try {
                const data = {
                    id: id,
                    name: name,
                    default_weight: default_weight
                }
                const req = await axios.post('/workout/updateWeightTraining', data);
                if (req.data.message) {
                    return alert(req.data.message)
                }   
                else{
                    alert('success');
                }                             
            } catch (e) {
                console.log(e);
            }
        }

        const add = async () => {
            if (name.value === "") {
                return alert("Name cannot be empty");
            }

            try {
                const data = {                    
                    name: name.value,
                    default_weight: default_weight.value
                }
                const req = await axios.post('/workout/addWeightTraining', data);
                if (req.data.message) {
                    return alert(req.data.message)
                }                
                types.value.push(data);

            } catch (e) {
                console.log(e);
            }

            name.value = null;
            default_weight.value = null;
        }

        onMounted(() => {
            handleTypes();
        });



        return {
            types,
            name,
            default_weight,
            
            add,
            update
        }
    }
}

</script>