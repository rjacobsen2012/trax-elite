<template>
    <div>
        <div v-show="rows.length > 0" class="autoscroller">
            <table class="common">
                <thead>
                    <tr>
                        <th
                            v-for="(value, key, index) in rows[0]"
                            :key="index"
                            v-html="properCase(key)"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in rows" :key="row.id" @click="showRow(row)">
                        <td
                            v-for="(item, index) in row"
                            :key="index"
                            v-html="item"
                        ></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

export default {
    name: "CommonTable",
    props: {
        rows: {type: [Object, Array], default: []},
    },
    methods: {
        showRow(row) {
            this.$emit('selectedRow', row)
        },
    },
}
</script>

<style scoped>

</style>
