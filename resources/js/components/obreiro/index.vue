<template>
    <div class="container-fluid">
        <Header />
        <router-view/>
    </div>
</template>

<script>
    import Header from './header.vue';
    export default {
        name: 'obreiro',
        mounted() {
            console.log('Component mounted.')
        },
        components: {Header}
    }
</script>