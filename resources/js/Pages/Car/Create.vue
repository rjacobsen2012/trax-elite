<template>
    <app-layout title="Cars">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Car
            </h2>
        </template>

        <div class="form-custom">
            <form @submit.prevent="submit">
                <div class="flex flex-row">
                    <form-label for="year" value="Year" class="form-label" />
                    <form-input id="year" type="number" class="input" v-model="carForm.year" required autofocus autocomplete="year"/>
                </div>
                <div class="flex flex-row">
                    <form-label for="make" value="Make" class="form-label" />
                    <form-input id="make" type="text" class="input" v-model="carForm.make" required autofocus autocomplete="make"/>
                </div>
                <div class="flex flex-row">
                    <form-label for="model" value="Model" class="form-label" />
                    <form-input id="model" type="text" class="input" v-model="carForm.model" required autofocus autocomplete="model"/>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <form-button :class="{ 'opacity-25': carForm.processing }" :disabled="carForm.processing">
                        Create
                    </form-button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>

    import AppLayout from "../../Layouts/AppLayout";
    import FormLabel from "../../Jetstream/FormLabel";
    import FormInput from "../../Jetstream/FormInput";
    import FormButton from "../../Jetstream/FormButton";
    export default {
        name: 'Car.Create',
        components: {FormButton, FormInput, FormLabel, AppLayout},
        props: [],
        data() {
            return {
                carForm: this.$inertia.form({
                    year: null,
                    make: null,
                    model: null,
                }),
            }
        },
        methods: {
            submit() {
                this.carForm
                    .post(this.route('car.store'), {
                        onSuccess: () => {
                            window.location = this.route('car.index')
                        }
                    })
            },
            clear () {
                this.$refs.form.reset()
            },
        },
    }
</script>

<style scoped lang="scss">

</style>
