<template>
    <div>
       <img :class="this.classes" src="/img/site-logo.jpg" />
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        name: 'SiteLogo',

        props: {
            size: {
                type: String,
                validator(value) {
                    // The value must match one of these strings
                    return ['small', 'large'].includes(value)
                },
                default: 'large'
            }
        },
       computed: {
           classes() {
               let baseClasses = `shadow-lg rounded-full`;

               return this.size === 'small'
                ? `${baseClasses} h-9 w-9`
                : `${baseClasses} h-20 w-20`;
           }
       }
    })
</script>
