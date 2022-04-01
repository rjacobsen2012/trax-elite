<template>
    <div class="flex-grow">
        <select
            :class="['select', customClass]"
            v-if="data.length >= 0"
            @change="changeValue"
            :disabled="data.length <= 1"
        >
            <option v-for="item in data" :key="item.id" :value="item.id" :selected="item.id === selected">{{item.name}}</option>
        </select>
        <div v-else><i>--</i></div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
export default defineComponent({
    name: 'FormSelect',
    props: {
        hasDefault: {type: Boolean, default: false},
        defaultKey: {type: [Number, String], default: null},
        defaultLabel: {type: String, default: 'Select One'},
        data: {type: Array, required: true},
        selected: {type: [String, Number, Boolean], default: null},
        id: {type: String, required: true},
        class: {type: String, default: ''},
    },
    data() {
        return {
            isDisabled: this.data.length === 1,
            loadedId: this.id,
            customClass: '',
        }
    },

    created() {
        this.customClass = this.class

        if (this.selected && this.data && this.data[this.selected]) {
            this.setSelectedValue(this.selected)
        }
    },

    watch: {
        class: function (value) {
            this.customClass = value
        }
    },

    emits: ['selectedOption'],

    methods: {
        changeValue(event) {
            this.setSelectedValue(event.target.value)
        },

        getValue(value) {
            switch(value) {
                case 'true':
                    return true;
                case 'false':
                    return false;
                default:
                    return value;
            }
        },

        setSelectedValue(value) {
            this.$emit('selectedOption', {
                element: this.id,
                option: this.getValue(value),
            })
        },
    },
})
</script>
