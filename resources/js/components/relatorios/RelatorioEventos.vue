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
                <v-col lg="12" md="12" sm="12">
                    <h3>Frequência dos Eventos</h3>
                </v-col>
            </v-row>

            <v-row class="mb-6">
                    <v-col lg="3" md="3" sm="12">
                            <v-text-field type="date" id="" label="Data Inicio" v-model="data_inicio"  @change="fetchEventos()" ></v-text-field>
                    </v-col>
                    <v-col lg="3" md="3" sm="12">
                            <v-text-field type="date" id="" label="Data Fim" v-model="data_fim"  @change="fetchEventos()" ></v-text-field>
                    </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" sm="12">

                    <v-simple-table dense>
                        <template v-slot:default>
                            <thead>
                            <tr>
                                <th class="text-left">
                                Descrição
                                </th>
                                <th class="text-left">
                                Data
                                </th>
                                <th class="text-left">
                                Hora
                                </th>
                                <th class="text-left">
                                Frequência Membresia (%)
                                </th>
                                <th class="text-left">
                                Visitantes
                                </th>
                                <th class="text-left">
                                Total Participantes
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in items" :key="item.descricao">
                                <td>{{ item.descricao }}</td>
                                <td>{{ item.data }}</td>
                                <td>{{ item.hora }}</td>
                                <td>{{ item.frequencia }}%</td>
                                <td>{{ item.participantes_visitantes }} visitante(s)</td>
                                <td>{{ item.participantes }}</td>
                            </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                    <br>
                    <p style="text-align:center"> Frequencia Média dos Eventos: {{media}}%</p>
                </v-col>
            </v-row>

           

        </v-container>
  </div>
</template>

<script>
import RelatorioEventosService from './RelatorioEventosService';

export default {
    name: 'relatorio-eventos',
    data() {
        return {
            RelatorioEventosService: new RelatorioEventosService(),
            isLoading: false,
            items: [],
            data_inicio:null,
            data_fim: null,
            media:null,

        };
    },
    watch: {
     
    },
    computed: {
  
    },
    methods: {

        async fetchEventos() {
            this.isLoading = true;
            await this.RelatorioEventosService.request('GET', 'get-data', null, {
                params: {
                    inicio: this.data_inicio,
                    fim: this.data_fim
                },
            }).then((response) => {
                this.items = response.data.eventos;
                this.media = response.data.frequencia_media;
                this.isLoading = false;
            });
        },

        filtro(){

        }

      
    },
    mounted() {
         this.fetchEventos();
    },
}
</script>

<style scooped>


</style>
