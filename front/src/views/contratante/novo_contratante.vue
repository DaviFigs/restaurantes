<script setup>
import { ref } from 'vue'
import { cadastrarContratante } from '../../services/contratante.js'

const nome_completo = ref('')
const email = ref('')
const senha = ref('')
const cpf = ref('')
const telefone = ref('')

const carregando = ref(false)
const erro = ref('')
const sucesso = ref('')

async function novoContratante() {

    erro.value = ''
    sucesso.value = ''

    if (
        !nome_completo.value ||
        !email.value ||
        !senha.value ||
        !cpf.value ||
        !telefone.value
    ) {
        erro.value = 'Preencha todos os campos.'
        return
    }

    carregando.value = true

    try {

        const dados = {
            nome_completo: nome_completo.value.trim(),
            email: email.value.trim(),
            senha: senha.value,
            cpf: cpf.value.trim(),
            telefone: telefone.value.trim()
        }

        const resposta = await cadastrarContratante(dados)

        const info = resposta.info?.[0]

        if (!info || info.cdg_erro !== 0) {
            throw new Error(
                info?.msg ||
                'Não foi possível cadastrar o contratante.'
            )
        }

        sucesso.value =
            info.msg ||
            'Contratante cadastrado com sucesso.'

        nome_completo.value = ''
        email.value = ''
        senha.value = ''
        cpf.value = ''
        telefone.value = ''

    } catch (error) {

        erro.value =
            error instanceof TypeError
                ? 'Não foi possível conectar ao servidor.'
                : error.message

    } finally {

        carregando.value = false

    }
}
</script>

<template>

    <main class="cadastro-container">

        <section class="cadastro-card">

            <h1>Criar conta</h1>

            <p class="descricao">
                Cadastre seus dados para criar seu restaurante.
            </p>

            <form @submit.prevent="novoContratante">

                <div class="campo">

                    <label for="nome">
                        Nome completo
                    </label>

                    <input
                        id="nome"
                        v-model="nome_completo"
                        type="text"
                        maxlength="100"
                        placeholder="Digite seu nome completo"
                        autocomplete="name"
                    >

                </div>

                <div class="campo">

                    <label for="email">
                        E-mail
                    </label>

                    <input
                        id="email"
                        v-model="email"
                        type="email"
                        maxlength="100"
                        placeholder="Digite seu e-mail"
                        autocomplete="email"
                    >

                </div>

                <div class="campo">

                    <label for="senha">
                        Senha
                    </label>

                    <input
                        id="senha"
                        v-model="senha"
                        type="password"
                        maxlength="256"
                        placeholder="Digite sua senha"
                        autocomplete="new-password"
                    >

                </div>

                <div class="campo">

                    <label for="cpf">
                        CPF
                    </label>

                    <input
                        id="cpf"
                        v-model="cpf"
                        type="text"
                        maxlength="11"
                        placeholder="Digite seu CPF"
                        inputmode="numeric"
                    >

                </div>

                <div class="campo">

                    <label for="telefone">
                        Telefone
                    </label>

                    <input
                        id="telefone"
                        v-model="telefone"
                        type="tel"
                        maxlength="20"
                        placeholder="Digite seu telefone"
                        autocomplete="tel"
                    >

                </div>

                <p
                    v-if="erro"
                    class="mensagem erro"
                >
                    {{ erro }}
                </p>

                <p
                    v-if="sucesso"
                    class="mensagem sucesso"
                >
                    {{ sucesso }}
                </p>

                <button
                    type="submit"
                    :disabled="carregando"
                >
                    {{ carregando
                        ? 'Cadastrando...'
                        : 'Criar conta'
                    }}
                </button>

            </form>

        </section>

    </main>

</template>

<style scoped>

.cadastro-container {
    min-height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;

    padding: 30px;
}

.cadastro-card {
    width: 100%;
    max-width: 450px;

    padding: 35px;

    border-radius: 12px;

    background: white;
}

h1 {
    margin-bottom: 8px;
}

.descricao {
    margin-bottom: 25px;
}

.campo {
    display: flex;
    flex-direction: column;

    margin-bottom: 18px;
}

.campo label {
    margin-bottom: 6px;
    font-weight: 600;
}

.campo input {
    padding: 11px;

    border: 1px solid #ccc;
    border-radius: 6px;

    font-size: 15px;
}

button {
    width: 100%;

    padding: 12px;

    border: none;
    border-radius: 6px;

    cursor: pointer;

    font-size: 16px;
}

button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.mensagem {
    margin-bottom: 15px;
}

.erro {
    color: #c62828;
}

.sucesso {
    color: #2e7d32;
}

</style>