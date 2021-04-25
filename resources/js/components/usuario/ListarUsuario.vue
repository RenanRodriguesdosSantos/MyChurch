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
                        <template v-slot:item.foto="{ item }">
                             <v-avatar size="30">
                                  <img
                                    :src="imagemPadrao"
                                    :alt="item.name"
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
                             v-if="item.tipo.slug != 'lider'"
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
import UsuarioService from './UsuarioService';

export default {
    name: 'listar-usuario',
    data() {
        return {
            usuarioService: new UsuarioService(),
            isLoading: false,
            items: [],
            imagemPadrao: '../images/foto-padrao.png',
            headers: [
                { text: 'Foto', value: 'foto', sortable: false, align: 'center' },
                { text: 'Nome', value: 'name', sortable: false, align: 'center' },
                { text: 'Email', value: 'email', sortable: false, align: 'center' },
                { text: 'Cago', value: 'tipo.descricao', sortable: false, align: 'center' },
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
        async fetchUsuarios() {
            this.isLoading = true;
            await this.usuarioService.request('GET', 'get-all-users').then((response) => {
                this.items = response.data;
                this.isLoading = false;
            });
        },
        async deleteUser() {
            this.isLoading = true;
            const params = {
                id: this.deletedItem.id
            }
            await this.usuarioService.request('POST', 'delete-user', params).then((response) => {
                if(response.status >= 200 && response.status <= 299) {
                    Vue.$toast.success('Operação realizada com sucesso');
                } else {
                    Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                }
                this.isLoading = false;
            });
        },
        editItem(item) {
            this.$router.push({ name: 'editar-usuario', params: {
                id: item.id,
            }});
        },
        deleteItem (item) {
            this.deletedItem = item;
            this.dialogDelete = true
        },

        async deleteItemConfirm () {
            await this.deleteUser();
            this.closeDelete();
            await this.fetchUsuarios();
        },
        closeDelete () {
            this.dialogDelete = false;
            this.deletedItem = null
        },
    },
    mounted() {
        this.fetchUsuarios();
    },
}
</script>

<style scooped>
.img-profile {
    height: 200px;
    width: auto;
}
</style>
