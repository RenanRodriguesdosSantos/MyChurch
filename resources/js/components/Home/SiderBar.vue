<template>
      <v-navigation-drawer style="float: left; height: 100%;" v-model="drawer" permanent dark color="#1A1E21">
          <template v-slot:prepend>
            <v-list-item two-line>
            <v-list-item-avatar>
                <img src="https://randomuser.me/api/portraits/women/81.jpg">
            </v-list-item-avatar>

            <v-list-item-content>
                <v-list-item-title>{{ $store.user }}</v-list-item-title>
                <v-list-item-subtitle>Logged In</v-list-item-subtitle>
            </v-list-item-content>
            </v-list-item>
        </template>

        <v-divider></v-divider>
        <v-list>
            <v-list-group :value="false" no-action prepend-icon="mdi-church">
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
            <v-list-group :value="false" no-action prepend-icon="mdi-account">
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
        </v-list>
        <template v-slot:append>
            <v-list-item link @click="logout()">
                <v-list-item-content>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-navigation-drawer>
</template>

<script>
import axios from 'axios';
export default {
    name: 'side-bar',
    data() {
        return {
            drawer: true,
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
        }
    },
}
</script>

<style>

</style>
