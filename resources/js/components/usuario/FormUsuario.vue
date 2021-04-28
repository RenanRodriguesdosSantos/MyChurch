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
                <h3 v-if="id">Edição de Usuário</h3>
                <h3 v-else>Cadastro de Usuário</h3>
            </v-col>
          </v-row>
          <v-form ref="userForm">
            <v-row class="text-lg-center">
                <v-col lg="12" md="12" sm="12">
                    <v-row class="text-lg-center" >
                        <v-col lg="6" md="6" sm="12">
                            <v-text-field label="Nome completo" v-model="user.name" outlined :rules="[...lengthRule, ...requiredRule]"></v-text-field>
                        </v-col>
                        <v-col lg="6" md="6" sm="12">
                            <v-text-field label="Email" type="text" v-model="user.email" outlined :rules="[...requiredRule, ...emailRule]" ></v-text-field>
                        </v-col>
                        <v-col lg="6" md="6" sm="12" v-if="!id">
                            <v-text-field
                                v-model="user.password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[...requiredRule, ...lengthRule]"
                                :type="show1 ? 'text' : 'password'"
                                label="Senha"
                                @click:append="show1 = !show1"
                                outlined
                            ></v-text-field>
                        </v-col>
                        <v-col lg="6" md="6" sm="12" v-else>
                            <v-text-field
                                v-model="user.new_password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :type="show1 ? 'text' : 'password'"
                                label="Senha (Deixe em branco para não alterar)"
                                @click:append="show1 = !show1"
                                outlined
                            ></v-text-field>
                        </v-col>
                        <v-col lg="6" md="6" sm="12">
                            <v-select v-model="user.type" outlined :items="tipos" item-text="descricao" item-value="id" filled
                            :rules="[...requiredRule]"
                            label="Tipo de usuário"></v-select>

                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
          </v-form>

        <v-row class="text-lg-left">
            <v-col lg="12" md="12" sm="12">
                <v-btn elevation="1" large dark color="blue" @click="save()">Salvar</v-btn>
            </v-col>
        </v-row>


        </v-container>
  </div>
</template>

<script>
import UsuarioService from './UsuarioService';
import TipoService from '../Tipo/TipoService';

export default {
    name: 'cadastro-usuario',
    props: ['id'],
    data() {
        return {
            usuarioService: new UsuarioService(),
            tipoService: new TipoService(),
            user: {
                name: null,
                email: null,
                type: null,
                password: null,
                new_password: null
            },
            password: null,
            show1: false,
            tipos: [],
            isLoading: null,
            requiredRule: [v => !!v || 'Este campo é obrigatório.'],
            lengthRule: [v => (v && v.length >= 8) || 'Esta campo deve conter 8 ou mais caracteres.'],
            emailRule: [v => (this.validateEmail(v)) || 'O e-mail informado é inválido.']
        };
    },
    methods: {
        async save() {
            if(this.$refs.userForm.validate()) {
                this.isLoading = true;
                const params = this.user;
                let response = null
                try {
                    response = await this.usuarioService.request('POST', 'cadastro', params).then(() => {
                        this.isLoading = false;
                        Vue.$toast.success('Operação realizada com sucesso');
                        this.$router.push('/usuario/listar');
                    });
                } catch(error) {
                    this.isLoading = false;
                    if(error.response.data.message) {
                        Vue.$toast.error(error.response.data.message);
                    } else {
                        Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                    }
                }
            }
        },
        validateEmail(value) {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return (value && pattern.test(value));
        },
        async loadUser() {
            this.isLoading = true;
            const params = {
                id: this.id,
            }
            await this.usuarioService.request('GET', 'get-user', null, { params }).then((response) => {
                this.user = response.data;
                this.isLoading = false;
            });
        },
        async loadTipos() {
            this.isLoading = true;
            const params = {
                id: this.id,
            }
            await this.tipoService.request('GET', 'get-all-types').then((response) => {
                this.tipos = response.data;
                this.isLoading = false;
            });
        },
        clearFields() {
            this.user = {
                name: null,
                email: null,
                type: null,
                password: null,
                new_password: null,
            };
        },
    },
    mounted() {
        this.clearFields();
        this.loadTipos();
        if (this.id) {
            this.loadUser();
        }
    },
}
</script>

<style scooped>
.img-profile {
    height: 200px;
    width: auto;
}
</style>
