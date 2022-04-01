<template>
    <app-layout title="Trip">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trip {{trip.data.date}}
            </h2>
        </template>

        <div class="flex flex-col w-full">
            <div class="flex flex-row justify-between">
                <h1>{{trip.data.date}} : {{trip.data.car}}</h1>
                <form-button class="error" @click="deleteSelected">Delete</form-button>
            </div>
            <div class="flex flex-row">
                <div class="flex xs3">Number of Miles:</div>
                <div class="flex xs9 pl-4">{{trip.data.miles}}</div>
            </div>
            <div class="flex flex-row">
                <div class="flex xs3"><h3>Total Miles:</h3></div>
                <div class="flex xs9 pl-4">{{trip.data.total}}</div>
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
            trip: {type: [Object, Array]},
        },
        data() {
            return {
                tripForm: this.$inertia.form({
                    id: this.trip.data.id,
                    miles: this.trip.data.miles,
                    total: this.trip.data.total,
                    car: this.trip.data.car,
                }),
            }
        },
        methods: {
            deleteSelected() {
                this.tripForm.delete(this.route('trip.destroy', [this.tripForm.id]), {
                    onSuccess: () => {
                        window.location = this.route('trip.index')
                    }
                })
            }
        },
        components: {FormButton, AppLayout}
    }
</script>

<style scoped lang="scss">

</style>
