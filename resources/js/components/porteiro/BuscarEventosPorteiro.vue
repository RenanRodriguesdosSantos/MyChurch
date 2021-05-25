<template>
  <div>
    <v-overlay :value="isLoading">
        <v-progress-circular
          indeterminate
          color="primary"
          size="64"
        ></v-progress-circular>
      </v-overlay>
    <v-form ref="dataForm">
        <v-row class="text-lg-center">
            <v-col lg="10" md="10" cols="10">
                <v-text-field label="Nome completo" type="date" v-model="data" outlined :rules="[...requiredRule]">

                </v-text-field>
            </v-col>
            <v-col lg="2" md="2" cols="2">
                <v-btn block flat x-large elevation="1" color="blue" dark @click="getEventoByDate()">Buscar</v-btn>
            </v-col>
        </v-row>
    </v-form>
    <v-list v-if="eventos" two-line>
        <v-list-item @click="goToChecklist(item.id)" link v-for="item in eventos" :key="item.id" class="list-item my-2">
            <template v-slot:default="{ active }">
                <v-list-item-content>
                    <v-list-item-title><b>{{item.nome}}</b></v-list-item-title>
                    <v-list-item-subtitle>{{ item.data }}</v-list-item-subtitle>
                </v-list-item-content>
            </template>
            <v-divider inset></v-divider>
        </v-list-item>
    </v-list>
  </div>
</template>

<script>
import EventoService from '../evento/EventoService'

export default {
    name: 'buscar-evento',
    data() {
        return {
            eventoService: new EventoService(),
            requiredRule: [(v) => !!v || "Este campo é obrigatório."],
            data: null,
            eventos: [],
            isLoading: false,
        };
    },
    methods: {
        getEventoByDate() {
            if (this.$refs.dataForm.validate()) {
                this.isLoading = true;
                this.eventoService.request('GET', 'get-evento-by-date', null, { params: {
                    data: this.data,
                } } ).then((response) => {
                    this.eventos = response.data;
                    this.isLoading = false;
                });

            }
        },
        goToChecklist(id) {
            this.$router.push({ name: 'checklist-evento', params: {
                id
            }});
        },
    },
}
</script>

<style>

</style>
