<template>
  <div>
    <v-overlay :value="isLoading">
      <v-progress-circular
        indeterminate
        color="primary"
        size="64"
      ></v-progress-circular>
    </v-overlay>
    <v-layout>
        <v-row>
            <v-col lg="6" md="6" cols="12">
                <total-de-visitas v-if="totalVisitas" :totalVisitas="totalVisitas">
                </total-de-visitas>
            </v-col>
            <v-col lg="6" md="6" cols="12">
                <cesta-por-mes v-if="totalVisitas" :cestaPorMes="cestaBasicas">
                </cesta-por-mes>
            </v-col>
        </v-row>

    </v-layout>

  </div>
</template>

<script>
import CestaPorMes from '../charts/CestaPorMes.vue'
import TotalDeVisitas from '../charts/TotalDeVisitas.vue'
import DashboardService from './DashboardService';
export default {
    components: {
        CestaPorMes,
        TotalDeVisitas,
    },
    name: 'Dashboard',
    data() {
        return {
            dashboardService: new DashboardService(),
            isLoading: false,
            selectedMonth: 5,
            totalVisitas: 0,
            visitasPorMes: 0,
            cestaBasicas: 0,
            months: [
                { value: 1, nome: "Janeiro" },
                { value: 2, nome: "Fevereiro" },
                { value: 3, nome: "Março" },
                { value: 4, nome: "Abril" },
                { value: 5, nome: "Maio" },
                { value: 6, nome: "Junho" },
                { value: 7, nome: "Julho" },
                { value: 8, nome: "Agosto" },
                { value: 9, nome: "Setembro" },
                { value: 10, nome: "Outubro" },
                { value: 11, nome: "Novembro" },
                { value: 12, nome: "Dezembro" },
            ],
        };
    },
    methods: {
        async getDashboardData() {
            this.isLoading = true;
            await this.dashboardService.request('GET', 'get-dashboard-data', null, {
                params: {
                    month: this.selectedMonth,
                },
            }).then((response) => {
                this.cestaBasicas = response.data['cestaBasicas'];
                this.visitasPorMes = response.data['visitasPorMes'];
                this.totalVisitas = response.data['totalVisitas'];
                this.isLoading = false;
            });
        }
    },
    created() {
        this.getDashboardData()
    },
}

</script>

<style>

</style>
