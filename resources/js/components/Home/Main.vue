<template>
    <v-app>
        <sider-bar></sider-bar>
        <v-main>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import SiderBar from './SiderBar.vue';

export default {
    props: ['user'],
    components: { SiderBar },
    name: 'main-component',
    created() {
        this.$store.dispatch('updateCurrentUser', JSON.parse(this.user));
    }
}
</script>

<style>

</style>
