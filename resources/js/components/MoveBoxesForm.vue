<script>
export default {
    name: 'MoveBoxesForm',
    data() {
        return {
            fromRoomId: '',
            toRoomId: '',
            boxesToMove: [{ fruit_type: '', box_count: 0 }]
        };
    },
    methods: {
        addBox() {
            this.boxesToMove.push({ fruit_type: '', box_count: 0 });
        },
        removeBox(index) {
            this.boxesToMove.splice(index, 1);
        },
        moveBoxes() {
            axios.patch('/api/warehouse/boxes/move', {
                from_room_id: this.fromRoomId,
                to_room_id: this.toRoomId,
                boxes: this.boxesToMove
            }).catch(error => {
                alert(error.response.data.message);
            });
        }
    }
}
</script>

<template>
    <div class="form-div">
        <h1>Move boxes</h1>
        <form @submit.prevent="moveBoxes">
            <input class="text-input" v-model="fromRoomId" placeholder="From Room ID">
            <input class="text-input" v-model="toRoomId" placeholder="To Room ID">
            <div v-for="(box, index) in boxesToMove" :key="index">
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
