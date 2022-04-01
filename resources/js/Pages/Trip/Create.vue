<template>
    <AppLayout title="Trips">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Trip
            </h2>
        </template>

        <div class="form-custom">
            <form @submit.prevent="submit">
                <div class="flex flex-row">
                    <form-label for="date" value="Date" class="form-label" />
                    <datepicker id="date" v-model="tripForm.date" required placeholder="Select Date" class="input-date-time w-full"/>
                </div>
                <div class="flex flex-row">
                    <form-label for="car" value="Car" class="form-label" />
                    <form-select id="car" v-model="tripForm.car_id" :selected="cars[0].id" :data="cars" required @selectedOption="selectCar"/>
                </div>
                <div class="flex flex-row">
                    <form-label for="miles" value="Miles" class="form-label" />
                    <form-input id="miles" type="text" class="input" v-model="miles" autocomplete="miles"/>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <form-button :class="{ 'opacity-25': tripForm.processing }" :disabled="tripForm.processing">
                        Create
                    </form-button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from "../../Layouts/AppLayout";
    import FormLabel from "../../Jetstream/FormLabel";
    import FormInput from "../../Jetstream/FormInput";
    import FormButton from "../../Jetstream/FormButton";
    import Datepicker from 'vue3-datepicker';
    import FormSelect from "../../Jetstream/FormSelect";

    export default {
        name: 'Trip.Create',
        components: {FormSelect, FormButton, FormInput, FormLabel, AppLayout, Datepicker},
        props: {
            cars: {type: [Object, Array]},
        },
        data() {
            return {
                tripForm: this.$inertia.form({
                    date: null,
                    car_id: this.cars[0].id,
                    miles: null,
                }),
                miles: 0,
            }
        },
        watch: {
            miles: function (value) {
                this.tripForm.miles = parseFloat(value)
            }
        },
        methods: {
            submit() {
                this.tripForm
                    .post(this.route('trip.store'), {
                        onSuccess: () => {
                            window.location = this.route('trip.index')
                        },
                        onError: (response) => {
                        }
                    })
            },
            selectCar(car) {
                this.tripForm.car_id = parseFloat(car.option)
            },
        },
    }
</script>

<style scoped lang="scss">

</style>
