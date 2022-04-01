<template>
    <app-layout title="Car">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Car {{car.data.year}} {{car.data.make}} {{car.data.model}}
            </h2>
        </template>

        <div class="flex flex-col w-full">
            <div class="flex flex-row justify-between">
                <h1>{{car.data.year}} {{car.data.make}} {{car.data.model}}</h1>
                <form-button :disabled="hasTrips" class="error" @click="deleteSelected">Delete</form-button>
            </div>
            <div class="flex flex-row">
                <div class="flex xs3">Number of Trips:</div>
                <div class="flex xs9 pl-4">{{car.data.trip_count}}</div>
            </div>
            <div class="flex flex-row">
                <div class="flex xs3"><h3>Total Trip Miles:</h3></div>
                <div class="flex xs9 pl-4">{{car.data.trip_miles}}</div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "../../Layouts/AppLayout";
    import FormButton from "../../Jetstream/FormButton";
    export default {
        name: 'Car.View',
        props: {
            car: {type: [Object, Array]},
            hasTrips: {type: Boolean, default: false},
        },
        data() {
            return {
                carForm: this.$inertia.form({
                    id: this.car.data.id,
                    year: this.car.data.year,
                    make: this.car.data.make,
                    model: this.car.data.model,
                }),
            }
        },
        methods: {
            deleteSelected() {
                this.carForm.delete(this.route('car.destroy', [this.carForm.id]), {
                    onSuccess: () => {
                        window.location = this.route('car.index')
                    }
                })
            }
        },
        components: {FormButton, AppLayout}
    }
</script>

<style scoped lang="scss">

</style>
