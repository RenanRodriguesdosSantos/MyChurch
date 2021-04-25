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
                <h3>Cadastro de membresia</h3>
            </v-col>
          </v-row>
          <v-form ref="membresiaForm">
            <v-row class="text-lg-center">
                <v-col lg="8" md="8" sm="12">
                    <v-row class="text-lg-center" >
                        <v-col lg="12" md="12" cols="12">
                            <v-text-field label="Nome completo" v-model="membro.nome" outlined :rules="[...lengthRule, ...requiredRule]"></v-text-field>
                        </v-col>
                        <v-col lg="12" md="12" cols="12">
                            <v-text-field label="Email" v-model="membro.email" outlined :rules="[...requiredRule, ...emailRule]" ></v-text-field>
                        </v-col>
                        <v-col lg="4" md="4" cols="12">
                            <v-text-field max-le label="CPF" v-model="membro.cpf" outlined :rules="[...cpfRule]"></v-text-field>
                        </v-col>
                        <v-col lg="4" md="4" cols="12">
                            <v-text-field label="Telefone" v-model="membro.telefone" outlined :rules="[...lengthRuleTelefone, ...requiredRule]" ></v-text-field>
                        </v-col>
                        <v-col lg="4" md="4" cols="12">
                            <v-text-field type="date" label="Data de batismo" v-model="membro.databatismo" :rules="[...requiredRule]" outlined ></v-text-field>
                        </v-col>
                        <v-col lg="12" md="12" cols="12">
                            <v-text-field label="Endereço" v-model="membro.endereco" outlined ></v-text-field>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col lg="4" md="4" cols="12">
                    <img class="img-profile" v-if="image" :src="image" >
                    <v-file-input
                        accept="image/*"
                        label="Foto"
                        outlined
                        v-model="membro.foto"
                        @change="imgToBase64()"
                    ></v-file-input>
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
import MembresiaService from './MembresiaService';

export default {
    name: 'cadastro-membresia',
    props: ['id'],
    data() {
        return {
            membresiaService: new MembresiaService(),
            membro: {
                nome: null,
                cpf: null,
                email: null,
                endereco: null,
                databatismo: null,
                telefone: null,
                foto: null,
            },
            isLoading: null,
            image: '../images/foto-padrao.png',
            requiredRule: [v => !!v || 'Este campo é obrigatório.'],
            lengthRule: [v => (v && v.length >= 3) || 'Esta campo deve conter 3 ou mais caracteres.'],
            lengthRuleTelefone: [v => (v && v.length === 11 ) || 'Telefne está em formato incorreto.'],
            cpfRule: [v => (v && this.validarCPF(v)) || 'O cpf informado é inválido.'],
            emailRule: [v => (this.validateEmail(v)) || 'O e-mail informado é inválido.']
        };
    },
    methods: {
        async save() {
            if(this.$refs.membresiaForm.validate()) {
                this.isLoading = true;
                const params = this.membro;
                params.foto = this.image
                await this.membresiaService.request('POST', 'cadastro', params).then((response) => {
                    this.isLoading = false;
                    if(response.status >= 200 && response.status <= 299) {
                        this.$router.push('/membresia/listar');
                        Vue.$toast.success('Operação realizada com sucesso');
                    } else {
                        Vue.$toast.error('Ocorreu um problema ao salvar o registro');
                    }
                });
            }
        },
        imgToBase64() {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.image = e.target.result;
            };
            reader.readAsDataURL(this.membro.foto);
        },
        validadeDataBatismo(val) {
            let validate = true;
            if (!!val && val.length === 10 && !moment(val, 'DD/MM/YYYY', true).isValid()) {
                validate = false;
                this.dataBirthValidate = false;
            }
            return validate;
        },
        validarCPF(cpfOrigem) {
            if (cpfOrigem && cpfOrigem.length === 11) {
                const cpf = cpfOrigem.replace(/\D/g, '');
                if (cpf.toString().length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
                let result = true;
                [9, 10].forEach((j) => {
                    let soma = 0;
                    let r;
                    cpf.split(/(?=)/).splice(0, j).forEach((e, i) => {
                        soma += parseInt(e, 10) * ((j + 2) - (i + 1));
                    });
                    r = soma % 11;
                    r = (r < 2) ? 0 : 11 - r;
                    if (r !== parseInt(cpf.substring(j, j + 1), 10)) result = false;
                });
                return result;
            } else {
                return false
            }
        return true;
        },
        validateEmail(value) {
            const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return (value && pattern.test(value));
        },
        async loadMembro() {
            this.isLoading = true;
            const params = {
                id: this.id,
            }
            await this.membresiaService.request('GET', 'get-membro', null, { params }).then((response) => {
                this.membro = response.data;
                if (this.membro.foto) { this.image = this.membro.foto };
                this.membro.foto = null;
                this.isLoading = false;
            });
        }
    },
    mounted() {
        if (this.id) {
            this.loadMembro();
        }
    },
}
</script>

<style scooped>
.img-profile {
    height: 200px;
    width: auto;
    text-align: center;
    align-content: center;
    align-items: center;
}
</style>
