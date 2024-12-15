<script>
export default {
    name: 'RemoveBoxesForm',
    data() {
        return {
            roomId: '',
            boxesToRemove: [{ fruit_type: '', box_count: 0 }]
        };
    },
    methods: {
        addBox() {
            this.boxesToRemove.push({ fruit_type: '', box_count: 0 });
        },
        removeBox(index) {
            this.boxesToRemove.splice(index, 1);
        },
        removeBoxes() {
            axios.delete('/api/warehouse/boxes', {data: {
                room_id: this.roomId,
                boxes: this.boxesToRemove
            }}).catch(error => {
                alert(error.response.data.message);
            });
        }
    }
}
</script>

<template>
    <div class="form-div">
        <h1>Remove boxes</h1>
        <form @submit.prevent="removeBoxes">
            <input class="text-input" v-model="roomId" placeholder="Room ID">
            <div v-for="(box, index) in boxesToRemove" :key="index">
                <input class="text-input" v-model="box.fruit_type" placeholder="Fruit Type">
                <input class="text-input" v-model="box.box_count" type="number" placeholder="Box Count">
                <button class="button button-red" style="margin-left: 10px" @click="removeBox(index)">Remove</button>
            </div>
            <button class="button button-blue" style="margin-right: 10px" type="button" @click="addBox">Add row</button>
            <button class="button button-green" type="submit">Confirm</button>
        </form>
    </div>
</template>

<style scoped>

</style>
