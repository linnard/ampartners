<template>
    <div class="container">
        <h2 class="h2 text-center">Опис вакансії</h2>
        <hr>
        <div v-html="vacancy.description"></div>
    </div>
</template>

<script>

    export default {
        props: ['vacancy'],
        methods: {

        },
        mounted() {

        }
    }
</script>
