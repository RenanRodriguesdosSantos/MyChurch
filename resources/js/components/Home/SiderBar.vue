<template>
    <div>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-navigation-drawer v-model="drawer" app dark color="#1A1E21">
          <template v-slot:prepend>
            <v-list-item two-line>
            <v-list-item-avatar>
                <img :src="imagemPadrao">
            </v-list-item-avatar>

            <v-list-item-content>
                <v-list-item-title v-text="currentUser.name"></v-list-item-title>
                <v-list-item-subtitle v-text="currentUser.tipo.slug"></v-list-item-subtitle>
            </v-list-item-content>
                <v-btn @click.stop="drawer = !drawer" icon><v-icon>mdi-chevron-left</v-icon></v-btn>
            </v-list-item>
        </template>

        <v-divider></v-divider>
        <v-list>

            <v-list-item link @click="goTo('home')" prepend-icon="mdi-cogs">
                    <v-list-item-icon>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item-content>
            </v-list-item>
            <v-list-group :value="false" no-action prepend-icon="mdi-church" v-if="checkForUserRole(['lider'])">

                <template v-slot:activator>
                <v-list-item-content>
                    <v-list-item-title >Membresia</v-list-item-title>
                </v-list-item-content>
                </template>

                <v-list-item link @click="goTo('cadastro-membresia')">
                    <v-list-item-content>
                        <v-list-item-title>Novo membro</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click="goTo('listar-membresia')">
                    <v-list-item-content>
                        <v-list-item-title>Lista de membros</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>
            <v-list-group :value="false" no-action prepend-icon="mdi-walk">

                <template v-slot:activator>
                <v-list-item-content>
                    <v-list-item-title >Visitantes</v-list-item-title>
                </v-list-item-content>
                </template>

                <v-list-item link @click="goTo('cadastro-visitante')">
                    <v-list-item-content>
                        <v-list-item-title>Novo visitante</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click="goTo('listar-visitante')">
                    <v-list-item-content>
                        <v-list-item-title>Lista de visitantes</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>
            <v-list-group :value="false" no-action prepend-icon="mdi-calendar-today" v-if="checkForUserRole(['lider'])">

                <template v-slot:activator>
                <v-list-item-content>
                    <v-list-item-title >Eventos</v-list-item-title>
                </v-list-item-content>
                </template>

                <v-list-item link @click="goTo('cadastro-evento')">
                    <v-list-item-content>
                        <v-list-item-title>Novo evento</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click="goTo('listar-evento')">
                    <v-list-item-content>
                        <v-list-item-title>Lista de eventos</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>
            <v-list-group :value="false" no-action prepend-icon="mdi-account" v-if="checkForUserRole(['lider'])">
                <template v-slot:activator>
                <v-list-item-content>
                    <v-list-item-title >Usuários</v-list-item-title>
                </v-list-item-content>
                </template>

                <v-list-item link @click="goTo('cadastro-usuario')">
                    <v-list-item-content>
                        <v-list-item-title>Novo usuário</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click="goTo('listar-usuario')">
                    <v-list-item-content>
                        <v-list-item-title>Lista de usuários</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>
            <v-list-group :value="false" no-action prepend-icon="mdi-home-group" v-if="checkForUserRole(['lider','obreiro'])">
                <template v-slot:activator>
                <v-list-item-content>
                    <v-list-item-title >Visitas</v-list-item-title>
                </v-list-item-content>
                </template>

                <v-list-item link @click="goTo('agendar-visita')">
                    <v-list-item-content>
                        <v-list-item-title>Agendar visita</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click="goTo('listar-visitas')">
                    <v-list-item-content>
                        <v-list-item-title>Visitas agendadas</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-group>
        </v-list>
        <template v-slot:append>
            <v-list-item link @click="logout()">
                <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-navigation-drawer>
    </div>
</template>

<script>
import axios from 'axios';
import {mapGetters} from 'vuex';

export default {
    name: 'side-bar',
    data() {
        return {
            drawer: true,
            imagemPadrao: '../images/foto-padrao.png',
        };
    },
    methods: {
        logout() {
            axios.post('logout').then(() => {
                document.location.reload();
            });
        },
        goTo(name) {
            this.$router.push({ name });
        },
        checkForUserRole(roles) {
            return roles.includes(this.currentUser.tipo.slug);
        }
    },
    computed: {
        ...mapGetters({
            currentUser: "GET_CURRENT_USER",
        })
    }
}
</script>

<style>

</style>
