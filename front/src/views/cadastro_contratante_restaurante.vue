<script setup>

import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'

import ContratanteForm from '../components/cadastro/form_contratante.vue'
import RestauranteForm from '../components/cadastro/form_restaurante.vue'

const router = useRouter()

const etapa = ref(1)

const erro = ref('')
const carregando = ref(false)

const dados = reactive({

    contratante: {
        nome_completo: '',
        email: '',
        senha: '',
        cpf: '',
        telefone: ''
    },

    restaurante: {
        nome: '',
        login_restaurante: '',
        cpf_cnpj: '',
        email: '',
        telefone: ''
    },

    endereco: {
        cep: '',
        logradouro: '',
        numero: '',
        complemento: '',
        bairro: '',
        cidade: '',
        estado: ''
    }

})


function proximaEtapa() {

    erro.value = ''

    etapa.value = 2

}


function voltarEtapa() {

    erro.value = ''

    etapa.value = 1

}


async function cadastrar() {

    erro.value = ''
    carregando.value = true

    try {

        console.log('Enviando cadastro:')
        console.log(dados)

        /*
         * Aqui entra a chamada da API:
         *
         * await cadastrarTudo(dados)
         */

        router.push('/login')

    } catch (error) {

        erro.value =
            error.message ||
            'Erro ao realizar cadastro.'

    } finally {

        carregando.value = false

    }

}

</script>


<template>

    <main class="cadastro-container">

        <section class="cadastro-card">

            <header>

                <h1>
                    {{ etapa === 1
                        ? 'Crie sua conta'
                        : 'Cadastre seu restaurante'
                    }}
                </h1>

                <p>
                    {{ etapa === 1
                        ? 'Informe seus dados para começar.'
                        : 'Agora configure seu restaurante.'
                    }}
                </p>

            </header>


            <!-- PROGRESSO -->

            <div class="progresso">

                <div
                    class="etapa"
                    :class="{
                        ativa: etapa === 1,
                        concluida: etapa === 2
                    }"
                >
                    <span>
                        {{ etapa === 2 ? '✓' : '1' }}
                    </span>

                    Seus dados
                </div>


                <div class="linha"></div>


                <div
                    class="etapa"
                    :class="{ ativa: etapa === 2 }"
                >
                    <span>2</span>

                    Restaurante
                </div>

            </div>


            <!-- FORMULÁRIO -->

            <ContratanteForm
                v-if="etapa === 1"
                v-model="dados.contratante"
                @proximo="proximaEtapa"
            />


            <RestauranteForm
                v-else
                v-model:restaurante="dados.restaurante"
                v-model:endereco="dados.endereco"
                @voltar="voltarEtapa"
                @cadastrar="cadastrar"
            />


            <p
                v-if="erro"
                class="erro"
            >
                {{ erro }}
            </p>

        </section>

    </main>

</template>


<style scoped>

.cadastro-container {
    min-height: 100vh;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 30px;

    background: #f5f6f8;
}

.cadastro-card {
    width: 100%;
    max-width: 560px;

    padding: 40px;

    background: white;

    border-radius: 16px;

    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.08);
}

header {
    margin-bottom: 30px;
}

header h1 {
    margin: 0 0 8px;

    color: #222;

    font-size: 28px;
}

header p {
    margin: 0;

    color: #777;
}


/* PROGRESSO */

.progresso {
    display: flex;
    align-items: center;

    margin-bottom: 30px;
}

.etapa {
    display: flex;
    align-items: center;
    gap: 8px;

    color: #aaa;

    font-size: 14px;
    font-weight: 600;

    white-space: nowrap;
}

.etapa span {
    width: 28px;
    height: 28px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #e8e8e8;
}

.etapa.ativa,
.etapa.concluida {
    color: #580b7c;
}

.etapa.ativa span,
.etapa.concluida span {
    background: #580b7c;

    color: white;
}

.linha {
    height: 1px;

    flex: 1;

    margin: 0 12px;

    background: #ddd;
}

.erro {
    margin-top: 20px;

    color: #c62828;

    font-size: 14px;
}

</style>