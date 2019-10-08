<template>

</template>

<script>
    export default {
        props: {
            children: {
                type: Object,
                default: () => {}
            },
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
