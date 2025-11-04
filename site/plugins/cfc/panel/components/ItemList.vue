<template>
    <div
        class="k-block k-block-type-profiles k-block-type-default"
        @click="$emit('open')"
    >
        <div class="k-block-title tw-mb-4">
            <svg
                aria-hidden="true"
                data-type="users"
                class="k-icon k-block-icon"
            >
                <use xlink:href="#icon-users"></use>
            </svg>
            <span class="k-block-name"> {{ title }} </span>
        </div>
        <div>
            <span v-for="(item, index) in _items">
                {{ item.text }}<span v-if="index != items.length - 1">, </span>
            </span>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            pages: [],
        };
    },
    props: {
        title: {
            type: String,
            required: true,
        },
        items: {
            type: Array,
            required: true,
        },
    },
    mounted: function () {
        this.items.forEach((page) => {
            this.pages.push(page);
        });
    },
    computed: {
        _items() {
            return this.pages;
        },
    },
};
</script>
