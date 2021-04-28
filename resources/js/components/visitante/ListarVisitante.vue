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
                    <h3>Lista de visitantes</h3>
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
                        <template v-slot:item.acoes="{ item }">
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
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
        <v-dialog v-model="dialogDelete" persistent max-width="600px">
          <v-card>
            <v-card-title class="headline">Tem certeza que deseja deletar este membro?</v-card-title>
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
import VisitanteService from './VisitanteService';

export default {
    name: 'listar-visitante',
    data() {
        return {
            visitanteService: new VisitanteService(),
            isLoading: false,
            items: [],
            headers: [
                { text: 'Nome', value: 'nome', sortable: false, align: 'center' },
                { text: 'Telefone', value: 'telefone', sortable: false, align: 'center' },
                { text: 'Ações', value: 'acoes', sortable: false, align: 'center' },
            ],
            deletedItem: null,
            dialogDelete: false,
        };
    },
    watch: {
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },
    methods: {
        async fetchVisitantes() {
            this.isLoading = true;
            await this.visitanteService.request('GET', 'get-all-visitantes').then((response) => {
                this.items = response.data;
                this.isLoading = false;
            });
        },
        async deleteVisitante() {
            this.isLoading = true;
            const params = {
                id: this.deletedItem.id
            }
            await this.visitanteService.request('POST', 'delete-visitante', params).then((response) => {
                if(response.status >= 200 && response.status <= 299) {
                    Vue.$toast.success('Operação realizada com sucesso');
                } else {
                    Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                }
                this.isLoading = false;
            });
        },
        editItem(item) {
            this.$router.push({ name: 'editar-visitante', params: {
                id: item.id,
            }});
        },
        deleteItem (item) {
            this.deletedItem = item;
            this.dialogDelete = true
        },

        async deleteItemConfirm () {
            await this.deleteVisitante();
            this.closeDelete();
            await this.fetchVisitantes();
        },
        closeDelete () {
            this.dialogDelete = false;
            this.deletedItem = null
        },
    },
    mounted() {
        this.fetchVisitantes();
    },
}
</script>

<style scooped>


</style>
