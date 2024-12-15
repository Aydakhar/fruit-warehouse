<script>
    import axios from "axios";
    // import Echo from 'laravel-echo';
    import AddBoxesForm from "./AddBoxesForm.vue";
    import MoveBoxesForm from "./MoveBoxesForm.vue";
    import RemoveBoxesForm from "./RemoveBoxesForm.vue";

    export default {
        components: {
            AddBoxesForm,
            MoveBoxesForm,
            RemoveBoxesForm
        },
        data() {
            return {
                rooms: []
            };
        },
        created() {
            this.fetchData();

            Echo.channel('warehouse').listen('WarehouseUpdated', () => {
                this.fetchData();
            })
        },
        methods: {
            fetchData() {
                axios.get('/api/warehouse').then(response => {
                    this.rooms = response.data;
                });
            }
        }
    };
</script>

<template>
    <div class="warehouse-container">
        <h1>Warehouse</h1>
        <div v-for="room in rooms" :key="room.id" class="room">
            <h2 class="room-title">{{ room.name }}</h2>
            <ul class="box-list">
                <li v-for="box in room.boxes" :key="box.id" class="box-item">
                    {{ box.fruit_type }}: {{ box.box_count }}
                </li>
            </ul>
        </div>
        <AddBoxesForm ></AddBoxesForm>
        <MoveBoxesForm ></MoveBoxesForm>
        <RemoveBoxesForm ></RemoveBoxesForm>
    </div>
</template>

<style scoped>

</style>
