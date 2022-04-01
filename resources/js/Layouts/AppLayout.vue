<template>
    <div>
        <Head :title="title" />

        <banner />

        <div class="min-h-screen w-full text-center">
            <top-navigation/>

            <!-- Page Heading -->
            <header class="shadow header-bar dashboard-header" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-left">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto pt-6">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Banner from "../Jetstream/Banner";
import TopNavigation from "../Components/Navigation/TopNavigation";

export default defineComponent({
    name: 'AppLayout',

    props: {
        title: String,
        leftLinks: {type:[Array], default: []},
    },

    components: {
        TopNavigation,
        Banner,
        Head,
    },
})
</script>
