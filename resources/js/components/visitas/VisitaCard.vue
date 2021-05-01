<template>
   <v-card class="card-border" :style="{ 'border-top-color' :statusColor }" elevation="5">
        <v-card-text>
            <v-layout column>
                <v-flex xs6 class="mb-2">
                    Criado por: <b>{{visita.criado_por.name}}</b>
                </v-flex>
                <v-flex xs6  class="mb-2">
                    Responsavel: <b>{{ visita.responsavel.name }}</b>
                </v-flex>
                <v-flex xs12  class="mb-2">
                    Data: <b> {{ dataVisita }} </b>
                </v-flex>
                <v-flex xs12 class="mb-2 descricao-text">
                    Descricao: {{visita.descricao}}
                </v-flex>
                <v-flex xs12  class="mb-2">
                    Status <b :style="{ 'color' :statusColor }">{{visita.status.descricao}}</b>
                </v-flex>
            </v-layout>

        </v-card-text>
        <v-card-actions class="pb-2 justify-center text-center">
            <!-- <span class="justify-center">Editar</span> -->
            <v-layout row class="mb-1">
                <v-flex class="mouse-cursor" @click="editItem()" xs6>
                    Editar <v-icon small>mdi-pencil</v-icon>
                </v-flex>
                    <v-divider
                      vertical
                    ></v-divider>
                <v-flex class="mouse-cursor" @click="confirmarVisita()" xs6>
                    Visitar <v-icon small>mdi-check</v-icon>
                </v-flex>
            </v-layout>
        </v-card-actions>
    </v-card>
</template>

<script>
import moment from 'moment';
export default {
    name: 'visita-card',
    props: ['visita'],
    data() {
        return {
            isLoading: false,
            visitas: [],
            fullData: null
        };
    },
    computed: {
        dataVisita() {
           return moment(this.visita.data_visita).format('DD/MM/YYYY HH:mm');
        },
        statusColor() {
            if (this.visita.status.slug === 'agendada') return 'blue';
                return 'green'
        }
    },
    methods: {
        confirmarVisita() {
            console.log('oi');
        },
        editItem() {
            console.log('oi');
        }
    }
}
</script>

<style scooped>

.card-border{
    border-radius: 14px !important;
    border: 3px solid;
}
.descricao-text {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    line-height: 1rem;
    max-height: 3rem;
}

.mouse-cursor {
    cursor: pointer;
}

</style>
