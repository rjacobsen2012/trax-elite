<template>
    <div>
        <Head :title="title" />

        <banner />

        <div class="min-h-screen w-full text-center">
            <top-navigation/>

            <!-- Page Heading -->
            <header class="shadow header-bar dashboard-header" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex flex-row justify-between">
                    <slot name="header"></slot>
                    <div><a href="/phpunit-coverage/index.html" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Code Test Coverage</a></div>
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
