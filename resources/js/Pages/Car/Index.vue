<template>
    <app-layout title="Cars">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cars
            </h2>
        </template>

        <div class="flex flex-col">
            <div class="flex flex-row justify-end">
                <form-button @click="addCarSelected">
                    Add Car
                </form-button>
            </div>
        </div>
        <common-table :rows="cars.data" class="pt-4" @selectedRow="rowClicked"/>
    </app-layout>
</template>

<script>
    import AppLayout from "../../Layouts/AppLayout";
    import CommonTable from "../../Components/Html/CommonTable";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import FormButton from "../../Jetstream/FormButton";
    export default {
        name: 'Car.Index',
        props: {
            cars: {type: [Object, Array]},
        },
        data() {
            return {
                headers: [
                    { text: 'Year', value: 'date' },
                    { text: 'Make', value: 'make' },
                    { text: 'Model', value: 'model' },
                ]
            }
        },
        watch: {},
        computed: {},
        methods: {
            rowClicked(row) {
                window.location = this.route('car.show', [row.id])
            },
            addCarSelected() {
                window.location = this.route('car.create')
            }
        },
        components: {FormButton, CommonTable, AppLayout, Head, Link}
    }
</script>

<style scoped lang="scss">

</style>
