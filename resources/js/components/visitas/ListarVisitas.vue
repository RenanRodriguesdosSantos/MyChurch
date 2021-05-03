<template>
  <div>
       <v-container class="">
            <v-overlay :value="isLoading">
                <v-progress-circular
                    indeterminate
                    color="primary"
                    size="64"
                ></v-progress-circular>
            </v-overlay>
           <v-row class="mb-6">

            <v-col v-for="visita in visitas" :key="visita.id" cols="12" lg="3" md="4" sm="3">
                <visita-card :visita="visita" :atualizarLista="fetchVisitas">
                </visita-card>
            </v-col>
          </v-row>



        </v-container>
  </div>
</template>

<script>
import VisitaCard from './VisitaCard';
import VisitaService from './VisitaService';

export default {
    components: {
        VisitaCard
    },
    data() {
        return {
            isLoading: false,
            visitaService: new VisitaService(),
            visitas: [],
        };
    },
    methods: {
        async fetchVisitas() {
            this.isLoading = true;
            await this.visitaService.request('GET', 'get-all-visitas').then((response) => {
                this.visitas = response.data;
                this.isLoading = false;
            });
        },
    },
    mounted() {
        this.fetchVisitas();
    }
}
</script>

<style scooped>


</style>
