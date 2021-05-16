<template>
    <div>
         <v-overlay :value="isLoading">
            <v-progress-circular
                indeterminate
                color="primary"
                size="64"
            ></v-progress-circular>
        </v-overlay>
        <v-container fluid>
            <v-card elevation="0">
                <v-toolbar
                    rounded
                    color="primary"
                    dark>
                    <v-text-field label="Nome"
                        v-model="nomeMembro" clearable @input="searchMembro()"
                        hide-details
                        prepend-icon="mdi-magnify"
                        single-line
                    ></v-text-field>
                    <!-- <v-spacer></v-spacer> -->
                    <v-btn v-if="$vuetify.breakpoint.mdAndUp" light class="ml-8 primary--text"
                        color="white"
                        @click="addVisitante()"

                        rounded
                         >
                        <span class="hidden-sm-and-down">Adicionar visitante</span>
                        <v-icon > mdi-plus</v-icon>

                    </v-btn>
                    <v-btn v-else light class="ml-8 primary--text"
                        color="white"
                        @click="addVisitante()"
                        small
                        fab
                         >
                        <v-icon > mdi-plus</v-icon>

                    </v-btn>

                </v-toolbar>
                <v-list two-line>
                    <v-list-item v-for="item in filteredMembros" :key="item.id" class="list-item my-2">
                        <template v-slot:default="{ active }">
                            <v-list-item-avatar>
                                <img
                                    :src="item.foto ? item.foto : imagemPadrao"
                                    :alt="item.nome"
                                    >
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{item.nome}}</v-list-item-title>
                                <v-list-item-subtitle>{{ item.tipo === 1 ? 'Membro' : 'Visitante'}}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action>
                                <v-checkbox v-model="item.checked" @change="addOrRemoveMembroFromEvento(item)"></v-checkbox>
                            </v-list-item-action>
                        </template>
                        <v-divider inset></v-divider>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-container>
        <form-visitante-dialog @saved="getAllMembros()" v-model="visitanteDialog">
        </form-visitante-dialog>
    </div>
</template>

<script>
import MembresiaEventoService from './MembresiaEventoService';
import MembresiaService from '../membresia/MembresiaService';
import FormVisitanteDialog from '../visitante/FormVisitanteDialog'
import { filter } from 'lodash';

export default {
    name: 'checklist-evento',
    components: {
        FormVisitanteDialog
    },
    data() {
        return {
            membresiaEventoService: new MembresiaEventoService(),
            membresiaService: new MembresiaService(),
            membros: [],
            isLoading: false,
            imagemPadrao: '../images/foto-padrao.png',
            nomeMembro: null,
            filteredMembros: [],
            visitanteDialog: false,
        };
    },
    methods: {
        addOrRemoveMembroFromEvento(item) {
            if (item.checked) {
                this.addMembro(item);
            } else {
                this.removeMembro(item);
            }
        },
        async addMembro(item) {
            this.isLoading = true;
            const params = {
                membro_id: item.id,
                evento_id: this.$route.params.id
            };
            await this.membresiaEventoService.request('POST', 'add-membro-to-evento', params);
            this.isLoading = false;
        },
        async removeMembro(item) {
            this.isLoading = true;
            const params = {
                membro_id: item.id,
                evento_id: this.$route.params.id
            };
            await this.membresiaEventoService.request('POST', 'remove-membro-from-evento', params);
            this.isLoading = false;
        },
        async getAllMembros() {
            this.isLoading = true;
            await this.membresiaEventoService.request('GET', 'get-all-membros', null, { params: {
                evento_id: this.$route.params.id,
            }}).then((response) => {
                this.membros = response.data;
                this.filteredMembros = this.membros;
            });
            this.isLoading = false;
        },
        searchMembro() {
            if (this.nomeMembro) {
                this.filteredMembros = filter(this.membros, membro => membro.nome.includes(this.nomeMembro));
            } else {
                this.filteredMembros = this.membros;
            }
        },
        addVisitante() {
            this.visitanteDialog = true;
        }
    },
    mounted() {
        this.getAllMembros();
    },

}
</script>

<style>
.list-item {
    border-radius: 5px;
    border: 2px rgb(212, 212, 212) solid;
}
</style>
