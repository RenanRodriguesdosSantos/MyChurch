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
        <v-row class="charts-container">
            <!-- <v-row > -->
                <v-col lg="12" md="12" cols="12">


                    <span class="dashboard-title">Dashboard
                         <v-icon size="40" color="red">mdi-chart-bar</v-icon>

                    </span>
                </v-col>
            <!-- </v-row> -->
            <v-col lg="5" md="5" cols="12" class="chart-item">
                <v-select class="max-width: 50px !important" color v-model="selectedMonth"
                :items="months" item-value="value" item-text="nome" filled @change="getDashboardData()"
                    outlined></v-select>
                <total-de-visitas class="charts-size" v-if="totalVisitas" :totalVisitas="totalVisitas">
                </total-de-visitas>
            </v-col>

            <v-col lg="5" md="5" cols="12" class="chart-item">
                <cesta-por-mes class="charts-size" v-if="cestaBasicas" :cestaPorMes="cestaBasicas">
                </cesta-por-mes>
            </v-col>

            <v-col lg="5" md="5" cols="12" class="chart-item">
                <visita-por-mes class="charts-size" v-if="visitasPorMes" :visitasPorMes="visitasPorMes">
                </visita-por-mes>
            </v-col>

            <v-col lg="5" md="5" cols="12" class="chart-item">
                <ultimos-eventos class="charts-size" v-if="visitasPorMes" :eventos="eventos.eventos">
                </ultimos-eventos>
            </v-col>
        </v-row>

    </v-layout>

  </div>
</template>

<script>
import CestaPorMes from '../charts/CestaPorMes.vue'
import VisitaPorMes from '../charts/VisitasPorMes'
import TotalDeVisitas from '../charts/TotalDeVisitas.vue'
import UltimosEventos from '../charts/UltimosEventos.vue'
import DashboardService from './DashboardService';
import moment from 'moment'
// import { map } from 'lodash';
export default {
    components: {
        CestaPorMes,
        TotalDeVisitas,
        VisitaPorMes,
        UltimosEventos,
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
            eventos: 0,
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
                this.eventos = response.data['relatorioEventos'];
                this.isLoading = false;
                // console.log(this.totalVisitas.map(item => item.month));
            });
        }
    },
    created() {
        this.getDashboardData();

    },
}

</script>

<style>
.charts-size {
    max-width: 320px !important;
    max-height: 320px !important;
}
.chart-item {
    display: flex;
    align-content: center;
    justify-content: center;
    border: 1px solid rgb(177, 177, 177);
    border-radius: 10px;
    width: 5% !important;
    margin-right: 15px;
    margin-bottom: 20px;
    /* box-shadow: 1px 2px; */
}

.charts-container {
    display: flex;
    align-items:center;
    justify-content: center;
    text-align: center;
}
.dashboard-title {
    font-size: 35px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    text-transform: uppercase;

}
</style>
