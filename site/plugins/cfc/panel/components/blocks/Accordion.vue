<template>
    <div
        class="k-block k-block-type-accordion k-block-type-default"
        @click="open"
    >
        <div class="k-block-title tw-mb-4">
            <k-writer
                ref="input"
                v-bind="textField"
                :disabled="true"
                :inline="true"
                :keys="keys"
                :value="content.title"
                @input="update({ title: $event })"
            />
            <svg
                aria-hidden="true"
                data-type="angle-down"
                class="k-icon k-block-icon"
            >
                <use xlink:href="#icon-angle-down"></use>
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        textField() {
            return this.field('title', {
                marks: true,
            });
        },
    },
};
</script>

<style>
.k-block-type-accordion {
    display: flex;
    align-items: center;
    line-height: 1.25em;
    font-size: var(--text-2xl);
    font-weight: var(--font-bold);
}
</style>
