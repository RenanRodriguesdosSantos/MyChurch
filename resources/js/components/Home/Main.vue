<template>
  <div class="container-fluid fill-height">
        <sider-bar>
        </sider-bar>
        <router-view>
        </router-view>
    </div>
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
