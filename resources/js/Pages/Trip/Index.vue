<template>
    <app-layout title="Trips">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trips
            </h2>
        </template>

        <div class="flex flex-col">
            <div class="flex flex-row justify-end">
                <form-button @click="addTripSelected">
                    Add Trip
                </form-button>
            </div>
        </div>
        <common-table :rows="trips.data" class="pt-4" @selectedRow="rowClicked"/>
    </app-layout>
</template>

<script>
    import AppLayout from "../../Layouts/AppLayout";
    import CommonTable from "../../Components/Html/CommonTable";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import FormButton from "../../Jetstream/FormButton";
    export default {
        name: 'Trip.Index',
        props: {
            trips: {type: [Object, Array]},
        },
        data() {
            return {
                headers: [
                    { text: 'Date', value: 'date' },
                    { text: 'Car', value: 'car' },
                    { text: 'Miles', value: 'miles' },
                    { text: 'Miles Balance', value: 'total' },
                ]
            }
        },
        watch: {},
        computed: {},
        methods: {
            rowClicked(row) {
                window.location = this.route('trip.show', [row.id])
            },
            addTripSelected() {
                window.location = this.route('trip.create')
            }
        },
        components: {FormButton, CommonTable, AppLayout, Head, Link}
    }
</script>

<style scoped lang="scss">

</style>
