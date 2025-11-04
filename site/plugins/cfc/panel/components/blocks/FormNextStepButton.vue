<template>
    <div
        class="k-block k-block-type-form-next-step-button k-block-type-default"
        @click="open"
    >
        <div class="k-block-title tw-mb-4">
            <svg
                aria-hidden="true"
                data-type="bolt"
                class="k-icon k-block-icon"
            >
                <use xlink:href="#icon-bolt"></use>
            </svg>
            <span class="k-block-name">
                Next Step Button: [{{ content.text }}]
            </span>
        </div>
    </div>
</template>

<script>
export default {};
</script>

<style></style>
