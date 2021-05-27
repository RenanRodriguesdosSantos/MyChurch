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
                    <h3>Frequência do {{ membro.tipo == '1'? "Membro":"Visitante"}} </h3>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="6" sm="12">
                    <v-row>
                        <v-col cols="12">
                            <v-row>
                                <v-col lg="4" md="4" sm="12">
                                    <v-text-field type="date" id="" label="Data Inicio" v-model="data_inicio" ></v-text-field>
                                </v-col>
                                <v-col lg="4" md="4" sm="12">
                                    <v-text-field type="date" id="" label="Data Fim" v-model="data_fim" ></v-text-field>
                                </v-col>
                                <v-col lg="3" md="3" cols="12">
                                    <v-btn elevation="1" large dark color="green" @click="fetchRelDada()">
                                        Buscar
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12">
                            <v-simple-table dense>
                                <template v-slot:default>
                                    <thead>
                                    <tr>
                                        <th class="text-left">
                                        Evento
                                        </th>
                                        <th class="text-left">
                                        Data e Hora
                                        </th>
                                        <th class="text-left">
                                        Presente
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in items" :key="item.descricao">
                                        <td>{{ item.nome }}</td>
                                        <td>{{ new Date(item.data).toLocaleDateString('pt-br', {
                                                year: 'numeric',
                                                month: 'numeric',
                                                day: 'numeric',
                                                hour: 'numeric',
                                                minute: 'numeric',
                                            })}}</td>
                                        <td>{{ item.presente?"SIM":"NÃO" }}</td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col md="6" sm="12">
                    <v-row>
                        <v-col cols="3">
                            <v-img class="img-profile" max-height="70" max-width="70" v-if="image" :src="image" />
                        </v-col>
                        <v-col cols="9">
                            Nome: <h3>{{membro.nome}}</h3>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            Frequência: <b>{{relatorio.frequencia}} %</b><br/>
                            Faltas: <b>{{relatorio.faltas}}</b><br/>
                            Visitas: <b>{{relatorio.visitas}}</b><br/>
                            Total de Cestas: <b>{{relatorio.cestas}}</b>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>



        </v-container>
  </div>
</template>

<script>
import RelatorioFrequenciaMembroVisitante from './RelatorioMembroVisitanteService';

export default {
    name: 'frequencia-membro-visitante',
    props: ["id"],
    data() {
        return {
            RelatorioEventosService: new RelatorioFrequenciaMembroVisitante(),
            isLoading: false,
            items: [],
            membro: {},
            relatorio: {},
            image: '../images/foto-padrao.png',
            data_inicio:null,
            data_fim: null,
        };
    },
    methods: {
        async fetchRelDada() {
            this.isLoading = true;
            await this.RelatorioEventosService.request('GET', 'get-data', null, {
                params: {
                    id: this.id,
                    inicio: this.data_inicio,
                    fim: this.data_fim
                },
            }).then((response) => {
                this.items = response.data.eventos;
                this.membro = response.data.membro;
                this.image = this.membro.foto?this.membro.foto:this.image;
                this.relatorio.visitas = response.data.visitas.total;
                this.relatorio.cestas = response.data.visitas.cestas?response.data.visitas.cestas:0;
                this.relatorio.frequencia = this.items.length>0?((this.items.reduce((frequencia, element) =>{
                    return (frequencia += element.presente?1:0);
                }, 0) * 100) / this.items.length):0;
                this.relatorio.faltas = this.items.reduce((frequencia, element) =>{
                    return (frequencia += element.presente?0:1);
                }, 0);
                this.isLoading = false;
            });
        },
    },
    mounted() {
         this.fetchRelDada();
    },
}
</script>

<style scooped>


</style>
