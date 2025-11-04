<template>
    <k-cfc-item-list title="Profiles" :items="items" @open="open" />
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
