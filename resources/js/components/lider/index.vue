<template>
    <div>
        <Header />
        <div class="container-fluid">
            <router-view/>
        </div>
    </div>
</template>

<script>
    import Header from './header.vue';
    export default {
        name: 'lider',
        mounted() {
            console.log('Component mounted.')
        },
        components: {Header}
    }
</script>