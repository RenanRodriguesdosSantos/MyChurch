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
                    <h3>Lista de eventos</h3>
                </v-col>
            </v-row>
            <v-row class="text-lg-center">
                <v-col lg="12" md="12" sm="12">
                    <v-data-table
                        :headers="headers"
                        :items="items"
                        class="elevation-1"
                        pagination.sync="pagination"
                        item-key="id"
                        :loading="isLoading"
                    >
                        <template v-slot:item.data="{ item }">
                            <!-- <span>{{new Date(item.data).toLocaleDateString() + ' - ' + new Date(item.data).getHours()+':'+new Date(item.data).getMinutes() }}</span> -->
                            <span>{{

                                new Date(item.data).toLocaleDateString('pt-br', {
                                year: 'numeric',
                                month: 'numeric',
                                day: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                            })

                                }}</span>
                        </template>
                        <template v-if="currentUser.tipo.slug !== 'porteiro'" v-slot:item.acoes="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click="editItem(item)"
                            >
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                small
                                @click="deleteItem(item)"
                            >
                                mdi-delete
                            </v-icon>
                            <v-icon v-if="item.status_nome === 'Não realizado'"
                                small
                                class="mr-2"
                                @click="finalizarEvento(item.id)"
                            >
                                mdi-check
                            </v-icon>
                        </template>
                        <template v-else v-slot:item.acoes="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click="goToChecklist(item.id)"
                            >
                                mdi-playlist-check
                            </v-icon>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog v-model="dialogDelete" persistent max-width="600px">
          <v-card>
            <v-card-title class="headline">Tem certeza que deseja deletar este evento?</v-card-title>
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
import EventoService from './EventoService';
import {mapGetters} from 'vuex';

export default {
    name: 'listar-evento',
    data() {
        return {
            eventoService: new EventoService(),
            isLoading: false,
            items: [],
            headers: [
                { text: 'Nome', value: 'nome', sortable: false, align: 'center' },
                { text: 'Data/Hora', value: 'data', sortable: false, align: 'center' },
                { text: 'Status', value: 'status_nome', sortable: false, align: 'center' },
                { text: 'Criador', value: 'user_nome', sortable: false, align: 'center' },
                { text: 'Ações', value: 'acoes', sortable: false, align: 'center' },
            ],
            deletedItem: null,
            dialogDelete: false,
        };
    },
    computed: {
        ...mapGetters({
            currentUser: "GET_CURRENT_USER",
        })
    },
    watch: {
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },
    methods: {
        async fetchEventos() {
            this.isLoading = true;
            await this.eventoService.request('GET', 'get-all-eventos').then((response) => {
                this.items = response.data;
                this.isLoading = false;
            });
        },
        async deleteEvento() {
            this.isLoading = true;
            const params = {
                id: this.deletedItem.id
            }
            await this.eventoService.request('POST', 'delete-evento', params).then((response) => {
                if(response.status >= 200 && response.status <= 299) {
                    Vue.$toast.success('Operação realizada com sucesso');
                } else {
                    Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                }
                this.isLoading = false;
            });
        },
        editItem(item) {
            this.$router.push({ name: 'editar-evento', params: {
                id: item.id,
            }});
        },
        deleteItem (item) {
            this.deletedItem = item;
            this.dialogDelete = true
        },

        async deleteItemConfirm () {
            await this.deleteEvento();
            this.closeDelete();
            await this.fetchEventos();
        },
        async finalizarEvento(id) {
            this.isLoading = true;

            await this.eventoService.request('PUT', 'finalizar-evento', { id }).then((response) => {
                if(response.status >= 200 && response.status <= 299) {
                    Vue.$toast.success('Operação realizada com sucesso');
                } else {
                    Vue.$toast.error('Ocorreu um problema ao atualizar o registro');
                }
                this.isLoading = false;
                this.fetchEventos();
            });
        },
        closeDelete () {
            this.dialogDelete = false;
            this.deletedItem = null
        },
    },
    mounted() {
        this.fetchEventos();
    },
}
</script>

<style scooped>

</style>
