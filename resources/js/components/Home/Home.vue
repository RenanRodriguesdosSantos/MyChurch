<template>
    <v-row justify="center" class="pt-md-12">
      <v-col v-if="currentUser.tipo.slug === 'lider'" md="12">
          <dashboard>
          </dashboard>
      </v-col>
      <v-col v-else md="5">
          <v-img max-height="400" max-width="500" :src="imagemLogo"></v-img><br/>
          <h1 class="text-center">Bem Vindo!</h1>
      </v-col>
    </v-row>
</template>

<script>
import Dashboard from './Dashboard.vue'
import {mapGetters} from 'vuex';

export default {
    components: { Dashboard },
    data(){
        return{
        imagemLogo: '../images/logo.png'
        }
    },
    computed: {
            ...mapGetters({
                currentUser: "GET_CURRENT_USER",
            })
        }

}
</script>

<style>

</style>
