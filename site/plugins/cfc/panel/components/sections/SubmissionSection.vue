<template>
    <section class="k-submission-section">
        <ul>
            <li v-for="group in submission" :key="group.id">
                <h2 class="k-headline group-headline">{{ group.label }}</h2>
                <ul class="group-content">
                    <li v-for="field in group.fields" :key="field.id">
                        <div class="field-label">
                            {{ field.label }} [{{ field.key }}]
                        </div>
                        <div class="field-answer">{{ field.value }}</div>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</template>
<script>
export default {
    data() {
        return {
            label: 'Submission',
            submission: [{ fish: 'fish' }],
        };
    },
    created() {
        this.load().then((response) => {
            this.label = response.label;
            this.submission = response.submission;
        });
    },
};
</script>

<style scoped>
.group-headline {
    font-size: 1.2rem;
}

.group-content {
    margin-top: 1rem;
    margin-bottom: 1rem;
}

.group-content li {
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.field-answer {
    margin-top: 0.5rem;
}
.field-label {
    font-weight: 500;
}
</style>
