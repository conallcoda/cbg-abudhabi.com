<template>
    <k-cfc-item-list title="Form Fields" :items="items" @open="open" />
</template>

<script>
export default {
    computed: {
        items() {
            return this.content.items;
        },
    },
};
</script>

<style></style>
