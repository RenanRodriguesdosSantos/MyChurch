<template>
    <div style="height: 100%">
        <v-card style="height: 100%" class="card-border" :style="{ 'border-top-color' :statusColor }" elevation="5">
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
                    <v-flex xs12 class="mb-2 descricao-text">
                        Endereço: {{visita.endereco}}
                    </v-flex>
                    <!-- <v-flex xs12  class="mb-2">
                        Status: <b :style="{ 'color' :statusColor }">{{visita.status.descricao}}</b>
                    </v-flex> -->

                </v-layout>

            </v-card-text>
            <v-card-actions class="pb-2 text-center">
                <!-- <span class="justify-center">Editar</span> -->
                <v-layout row class="mb-1">
                    <v-flex class="mouse-cursor mb-2" v-if="visita.criado_por.id == currentUser.id" @click="editItem(visita.id)" xs6>
                        Editar <v-icon small>mdi-pencil</v-icon>
                    </v-flex>
                        <v-divider vertical v-if="visita.criado_por.id == currentUser.id"></v-divider>
                    <v-flex class="mouse-cursor mb-2" v-if="visita.criado_por.id == currentUser.id"  @click="deleteItem(visita.id)" xs6>
                        Excluir <v-icon small>mdi-delete</v-icon>
                    </v-flex>
                    <v-flex class="mouse-cursor" @click="confirmarVisita(visita.id)" xs12>
                        Visitar <v-icon small>mdi-check</v-icon>
                    </v-flex>
                </v-layout>
            </v-card-actions>
        </v-card>
        <v-dialog v-model="dialogDelete" persistent max-width="600px">
          <v-card>
            <v-card-title class="headline">Tem certeza que deseja deletar esta visita?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="error" text @click="closeDelete">Cancelar</v-btn>
              <v-btn color="success" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
    </div>
</template>

<script>
import moment from 'moment';
import VisitaService from './VisitaService';
import {mapGetters} from 'vuex';
export default {
    name: 'visita-card',
    props: ['visita','atualizarLista'],
    data() {
        return {
            isLoading: false,
            visitas: [],
            fullData: null,
            deletedItem: null,
            dialogDelete: false,
            visitaService: new VisitaService()
        };
    },
    computed: {
        dataVisita() {
           return moment(this.visita.data_visita).format('DD/MM/YYYY HH:mm');
        },
        statusColor() {
            if (this.visita.status.slug === 'agendada') return 'blue';
                return 'green'
        },
        ...mapGetters({
            currentUser: "GET_CURRENT_USER",
        })
    },
    methods: {
        confirmarVisita(idVisita) {
            this.$router.push({name: "realizar-visita", params: {id: idVisita}});
        },
        editItem(idVisita) {
            this.$router.push({name: "editar-visita", params: {id: idVisita}});
        },
        deleteItem (item) {
            this.deletedItem = item;
            this.dialogDelete = true
        },
        async deleteItemConfirm () {
            await this.deleteVisita();
            this.closeDelete();
            //await this.fetchVisitas();
        },
        closeDelete () {
            this.dialogDelete = false;
            this.deletedItem = null
        },
        async deleteVisita() {
            this.isLoading = true;
            const params = {
                id: this.deletedItem
            }
            await this.visitaService.request('POST', 'delete-visita', params).then((response) => {
                if(response.status >= 200 && response.status <= 299) {
                    Vue.$toast.success('Operação realizada com sucesso');
                    this.atualizarLista();
                } else {
                    Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                }
                this.isLoading = false;
            });
        }
    },
    watch: {
        dialogDelete (val) {
            val || this.closeDelete()
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

