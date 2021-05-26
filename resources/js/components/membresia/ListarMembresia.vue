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
                    <h3>Lista de membros</h3>
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
                        <template v-slot:item.ultimapresenca="{ item }">
                            --/--/----
                        </template>
                        <template v-slot:item.foto="{ item }">
                             <v-avatar size="30">
                                  <img
                                    :src="item.foto ? item.foto : imagemPadrao"
                                    :alt="item.nome"
                                  >
                                </v-avatar>

                        </template>
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
                                class="mr-2"
                                @click="deleteItem(item)"
                            >
                                mdi-delete
                            </v-icon>
                            <v-icon
                                small
                                @click="relatorio(item)"
                            >
                                mdi-file-chart
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
import MembresiaService from './MembresiaService';

export default {
    name: 'listar-membresia',
    data() {
        return {
            membresiaService: new MembresiaService(),
            isLoading: false,
            items: [],
            imagemPadrao: '../images/foto-padrao.png',
            headers: [
                { text: 'Foto', value: 'foto', sortable: false, align: 'center' },
                { text: 'Nome', value: 'nome', sortable: false, align: 'center' },
                { text: 'Email', value: 'email', sortable: false, align: 'center' },
                { text: 'Telefone', value: 'telefone', sortable: false, align: 'center' },
                { text: 'Ultima presença', value: 'ultimapresenca', sortable: false, align: 'center' },
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
        async fetchMembros() {
            this.isLoading = true;
            await this.membresiaService.request('GET', 'get-membros').then((response) => {
                this.items = response.data;
                this.isLoading = false;
            });
        },
        async deleteMembro() {
            this.isLoading = true;
            const params = {
                id: this.deletedItem.id
            }
            await this.membresiaService.request('POST', 'delete-membro', params).then((response) => {
                if(response.status >= 200 && response.status <= 299) {
                    Vue.$toast.success('Operação realizada com sucesso');
                } else {
                    Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                }
                this.isLoading = false;
            });
        },
        editItem(item) {
            this.$router.push({ name: 'editar-membresia', params: {
                id: item.id,
            }});
        },
        deleteItem (item) {
            this.deletedItem = item;
            this.dialogDelete = true
        },
        relatorio(item) {
            this.$router.push({ name: 'frequencia-membro-visitante', params: {
                id: item.id,
            }});
        },
        async deleteItemConfirm () {
            await this.deleteMembro();
            this.closeDelete();
            await this.fetchMembros();
        },
        closeDelete () {
            this.dialogDelete = false;
            this.deletedItem = null
        },
    },
    mounted() {
        this.fetchMembros();
    },
}
</script>

<style scooped>
.img-profile {
    height: 200px;
    width: auto;
}
</style>
