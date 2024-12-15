<script>
export default {
    name: 'AddBoxesForm',
    data() {
        return {
            roomId: '',
            newBoxes: [{ fruit_type: '', box_count: 0 }]
        };
    },
    methods: {
        addBox() {
            this.newBoxes.push({ fruit_type: '', box_count: 0 });
        },
        removeBox(index) {
            this.newBoxes.splice(index, 1);
        },
        addBoxes() {
            axios.post('/api/warehouse/boxes', {
                room_id: this.roomId,
                boxes: this.newBoxes
            });
        }
    }
}
</script>

<template>
    <div class="form-div">
        <h1>Add boxes</h1>
        <form @submit.prevent="addBoxes">
            <input class="text-input" v-model="roomId" placeholder="Room ID">
            <div v-for="(box, index) in newBoxes" :key="index">
                <input class="text-input" v-model="box.fruit_type" placeholder="Fruit">
                <input class="text-input" v-model="box.box_count" placeholder="Number of boxes">
                <button class="button button-red" style="margin-left: 10px" @click="removeBox(index)">Remove</button>
            </div>
            <button class="button button-blue" style="margin-right: 10px" type="button" @click="addBox">Add row</button>
            <button class="button button-green" type="submit">Confirm</button>
        </form>
    </div>
</template>

<style scoped>

</style>
