<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import SiteLogo from "./SiteLogo";
</script>

<template>
    <Link :href="'/'">
        <site-logo/>
    </Link>
</template>
