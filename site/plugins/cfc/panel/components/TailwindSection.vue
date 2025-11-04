<script>
export default {
    data() {
        return {
            label: undefined,
        };
    },

    async created() {
        // `load` is provided by Kirby in section components
        const response = await this.load();
        this.label = response.label || 'Tailwind Section';
    },
};
</script>

<template>
    <k-section :label="label">
        <div class="tw-rounded-xl tw-mt-4 tw-bg-gray-500 tw-p-1">
            Styled by Tailwind CSS
        </div>
    </k-section>
</template>
