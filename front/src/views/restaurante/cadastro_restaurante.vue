<script setup>

import { ref } from 'vue'
import { cadastrarRestaurante } from '../../services/restaurante.js'


/*
|--------------------------------------------------------------------------
| Dados do restaurante
|--------------------------------------------------------------------------
*/

const restaurante = ref({
    nome: '',
    cpf_cnpj: '',
    telefone: '',
    email: '',
    login_restaurante: ''
})


/*
|--------------------------------------------------------------------------
| Dados do endereço
|--------------------------------------------------------------------------
*/

const endereco = ref({
    logradouro: '',
    numero: '',
    complemento: '',
    bairro: '',
    cidade: '',
    estado: '',
    cep: ''
})


/*
|--------------------------------------------------------------------------
| Estado da tela
|--------------------------------------------------------------------------
*/

const carregando = ref(false)
const mensagem = ref('')
const erro = ref(false)


/*
|--------------------------------------------------------------------------
| Cadastro
|--------------------------------------------------------------------------
*/

async function cadastrar() {

    carregando.value = true
    mensagem.value = ''
    erro.value = false

    try {

        const dados = {
            endereco: endereco.value,
            restaurante: restaurante.value
        }

        const resposta = await cadastrarRestaurante(dados)

        console.log('Resposta da API:', resposta)


        /*
         * Verifica o retorno da sua API
         */

        if (
            resposta.info &&
            resposta.info[0] &&
            resposta.info[0].cdg_erro === 0
        ) {

            mensagem.value =
                resposta.info[0].msg

            erro.value = false

            /*
             * Limpa o formulário
             */

            restaurante.value = {
                nome: '',
                cpf_cnpj: '',
                telefone: '',
                email: '',
                login_restaurante: ''
            }

            endereco.value = {
                logradouro: '',
                numero: '',
                complemento: '',
                bairro: '',
                cidade: '',
                estado: '',
                cep: ''
            }

        } else {

            mensagem.value =
                resposta.info?.[0]?.msg ||
                'Erro ao cadastrar restaurante.'

            erro.value = true
        }

    } catch (e) {

        console.error(e)

        mensagem.value =
            'Não foi possível conectar com a API.'

        erro.value = true

    } finally {

        carregando.value = false

    }
}

</script>


<template>

    <main class="cadastro-restaurante">

        <h1>
            Cadastro de Restaurante
        </h1>


        <!--
        ============================================================
        RESTAURANTE
        ============================================================
        -->

        <section>

            <h2>
                Dados do Restaurante
            </h2>


            <div>

                <label>
                    Nome
                </label>

                <input
                    v-model="restaurante.nome"
                    type="text"
                    placeholder="Nome do restaurante"
                >

            </div>


            <div>

                <label>
                    CPF / CNPJ
                </label>

                <input
                    v-model="restaurante.cpf_cnpj"
                    type="text"
                    placeholder="CPF ou CNPJ"
                >

            </div>


            <div>

                <label>
                    Telefone
                </label>

                <input
                    v-model="restaurante.telefone"
                    type="text"
                    placeholder="Telefone"
                >

            </div>


            <div>

                <label>
                    E-mail
                </label>

                <input
                    v-model="restaurante.email"
                    type="email"
                    placeholder="E-mail"
                >

            </div>


            <div>

                <label>
                    Login do Restaurante
                </label>

                <input
                    v-model="restaurante.login_restaurante"
                    type="text"
                    placeholder="Login"
                >

            </div>

        </section>


        <!--
        ============================================================
        ENDEREÇO
        ============================================================
        -->

        <section>

            <h2>
                Endereço
            </h2>


            <div>

                <label>
                    CEP
                </label>

                <input
                    v-model="endereco.cep"
                    type="text"
                    placeholder="CEP"
                >

            </div>


            <div>

                <label>
                    Logradouro
                </label>

                <input
                    v-model="endereco.logradouro"
                    type="text"
                    placeholder="Rua / Avenida"
                >

            </div>


            <div>

                <label>
                    Número
                </label>

                <input
                    v-model="endereco.numero"
                    type="text"
                    placeholder="Número"
                >

            </div>


            <div>

                <label>
                    Complemento
                </label>

                <input
                    v-model="endereco.complemento"
                    type="text"
                    placeholder="Complemento"
                >

            </div>


            <div>

                <label>
                    Bairro
                </label>

                <input
                    v-model="endereco.bairro"
                    type="text"
                    placeholder="Bairro"
                >

            </div>


            <div>

                <label>
                    Cidade
                </label>

                <input
                    v-model="endereco.cidade"
                    type="text"
                    placeholder="Cidade"
                >

            </div>


            <div>

                <label>
                    Estado
                </label>

                <input
                    v-model="endereco.estado"
                    type="text"
                    maxlength="2"
                    placeholder="UF"
                >

            </div>

        </section>


        <!--
        ============================================================
        MENSAGEM
        ============================================================
        -->

        <p v-if="mensagem">

            {{ mensagem }}

        </p>


        <!--
        ============================================================
        BOTÃO
        ============================================================
        -->

        <button
            @click="cadastrar"
            :disabled="carregando"
        >

            {{ carregando ? 'Cadastrando...' : 'Cadastrar Restaurante' }}

        </button>

    </main>

</template>