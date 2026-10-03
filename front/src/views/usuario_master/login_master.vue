<script setup>

import { ref } from 'vue'
import { useRouter } from 'vue-router'

import { login_usuario_master } from '../../services/usuario_master.js'

const router = useRouter()

const email = ref('')
const senha = ref('')

const carregando = ref(false)
const erro = ref('')
const sucesso = ref('')


async function fazerLogin() {

    erro.value = ''
    sucesso.value = ''
    carregando.value = true

    try {

        const resultado = await login_usuario_master({
            email: email.value.trim(),
            senha: senha.value
        })

        const info = resultado?.info?.[0]

        if (
            !info ||
            info.cdg_erro !== 0
        ) {
            throw new Error(
                info?.msg ||
                'Não foi possível realizar o acesso.'
            )
        }

        if (resultado.dados) {

            localStorage.setItem(
                'crm-sessao-master',
                JSON.stringify(resultado.dados)
            )

        }

        sucesso.value =
            info.msg ||
            'Autenticação realizada com sucesso.'

        router.push('/home_master')

    } catch (error) {

        erro.value =
            error instanceof TypeError
                ? 'Não foi possível conectar ao serviço de autenticação.'
                : error.message

    } finally {

        carregando.value = false

    }

}


function voltarLogin() {

    router.push('/login')

}

</script>


<template>

    <main class="login-page">

        <!-- PAINEL ESQUERDO -->

        <section class="intro-panel">

            <div class="brand-mark">
                TM
            </div>

            <p class="eyebrow">
                Tá na Mesa
            </p>

            <h1>
                Controle sua operação
                de forma centralizada.
            </h1>

            <p class="intro-copy">
                Acesse sua conta master para
                administrar seus restaurantes,
                usuários e configurações.
            </p>

            <div
                class="signal-list"
                aria-label="Recursos do sistema"
            >

                <span>
                    <i></i>
                    Gestão centralizada
                </span>

                <span>
                    <i></i>
                    Administração de restaurantes
                </span>

                <span>
                    <i></i>
                    Controle de usuários
                </span>

            </div>

        </section>


        <!-- PAINEL DE LOGIN -->

        <section
            class="login-panel"
            aria-labelledby="login-title"
        >

            <div class="login-heading">

                <p class="eyebrow">
                    Acesso Master
                </p>

                <h2 id="login-title">
                    Entre na sua conta
                </h2>

                <p>
                    Acesse utilizando seu e-mail e senha.
                </p>

            </div>


            <form
                class="auth-form"
                @submit.prevent="fazerLogin"
            >

                <!-- E-MAIL -->

                <div class="campo">

                    <label for="email">
                        E-mail
                    </label>

                    <input
                        id="email"
                        v-model="email"
                        name="email"
                        type="email"
                        maxlength="100"
                        autocomplete="email"
                        placeholder="seu@email.com"
                        required
                    >

                </div>


                <!-- SENHA -->

                <div class="campo">

                    <label for="senha">
                        Senha
                    </label>

                    <input
                        id="senha"
                        v-model="senha"
                        name="senha"
                        type="password"
                        maxlength="256"
                        autocomplete="current-password"
                        placeholder="Digite sua senha"
                        required
                    >

                </div>


                <!-- ERRO -->

                <p
                    v-if="erro"
                    class="feedback error"
                    role="alert"
                >
                    {{ erro }}
                </p>


                <!-- SUCESSO -->

                <p
                    v-if="sucesso"
                    class="feedback success"
                    role="status"
                >
                    {{ sucesso }}
                </p>


                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="botao-cadastro"
                    :disabled="carregando"
                >

                    {{
                        carregando
                            ? 'Entrando...'
                            : 'Entrar'
                    }}

                    <span aria-hidden="true">
                        →
                    </span>

                </button>

            </form>


            <!-- VOLTAR PARA LOGIN NORMAL -->

            <div class="login-separator">
                <span>ou</span>
            </div>


            <div class="voltar-login">

                <p>
                    Deseja acessar como usuário do restaurante?
                </p>

                <button
                    type="button"
                    class="botao-secundario"
                    @click="voltarLogin"
                >
                    Login do Restaurante
                </button>

            </div>


            <!-- SUPORTE -->

            <p class="support">

                Problemas para acessar?

                <a
                    href="mailto:suporte@crminteligente.com"
                >
                    Fale com o suporte
                </a>

            </p>

        </section>

    </main>

</template>


<style scoped>

.login-page {

    min-height: 100vh;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        minmax(420px, 520px);

    background: #f5f6f8;

}


/* ========================================
   PAINEL ESQUERDO
======================================== */

.intro-panel {

    display: flex;

    flex-direction: column;

    justify-content: center;

    padding: 70px;

    background: var(--mint-dark);

    color: white;

}

.brand-mark {

    width: 58px;
    height: 58px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-bottom: 25px;

    border-radius: 14px;

    background: rgba(255, 255, 255, 0.15);

    font-size: 20px;

    font-weight: 700;

}

.eyebrow {

    margin: 0 0 12px;

    font-size: 13px;

    font-weight: 700;

    letter-spacing: 0.08em;

    text-transform: uppercase;

}

.intro-panel .eyebrow {

    color: rgba(255, 255, 255, 0.75);

}

.intro-panel h1 {

    max-width: 600px;

    margin: 0;

    font-size: clamp(38px, 4vw, 62px);

    line-height: 1.05;

    letter-spacing: -0.03em;

}

.intro-copy {

    max-width: 540px;

    margin: 25px 0 35px;

    color: rgba(255, 255, 255, 0.82);

    font-size: 17px;

    line-height: 1.6;

}

.signal-list {

    display: flex;

    flex-direction: column;

    gap: 15px;

}

.signal-list span {

    display: flex;

    align-items: center;

    gap: 10px;

    color: rgba(255, 255, 255, 0.9);

    font-size: 14px;

}

.signal-list i {

    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: white;

}


/* ========================================
   PAINEL DIREITO
======================================== */

.login-panel {

    display: flex;

    flex-direction: column;

    justify-content: center;

    padding: 55px;

    background: #fff;

}

.login-heading {

    margin-bottom: 0;

}

.login-heading .eyebrow {

    color: var(--mint-dark);

}

.login-heading h2 {

    margin: 0 0 10px;

    color: var(--ink);

    font-size: 30px;

    line-height: 1.2;

}

.login-heading p:last-child {

    margin: 0;

    color: #777;

    line-height: 1.5;

}


/* ========================================
   FORMULÁRIO
======================================== */

.auth-form {

    margin-top: 2.5rem;

}

.campo {

    display: flex;

    flex-direction: column;

    margin-bottom: 1.2rem;

}

.campo label {

    display: block;

    color: var(--ink);

    font-size: 0.82rem;

    font-weight: 700;

    margin: 0 0 0.45rem;

}

.campo input {

    width: 100%;

    box-sizing: border-box;

    border: 1px solid var(--line);

    background: #fff;

    color: var(--ink);

    padding: 0.95rem 1rem;

    font: inherit;

    outline: none;

    transition:
        border-color 0.2s,
        box-shadow 0.2s;

}

.campo input:focus {

    border-color: var(--mint-dark);

    box-shadow:
        0 0 0 3px
        rgba(40, 114, 101, 0.12);

}


/* ========================================
   BOTÃO LOGIN
======================================== */

.botao-cadastro {

    width: 100%;

    margin-top: 1.8rem;

    padding: 1rem 1.2rem;

    display: flex;

    align-items: center;

    justify-content: space-between;

    border: 0;

    border-radius: 0.75rem;

    background: var(--mint-dark);

    color: #fff;

    font: inherit;

    font-weight: 700;

    cursor: pointer;

    transition:
        background 0.2s,
        transform 0.2s,
        opacity 0.2s;

}

.botao-cadastro:hover:not(:disabled) {

    background: #1d5c51;

    transform: translateY(-2px);

}

.botao-cadastro:disabled {

    opacity: 0.65;

    cursor: wait;

}


/* ========================================
   FEEDBACK
======================================== */

.feedback {

    margin: 0 0 18px;

    font-size: 14px;

    line-height: 1.4;

}

.error {

    color: #c62828;

}

.success {

    color: #2e7d32;

}


/* ========================================
   SEPARADOR
======================================== */

.login-separator {

    display: flex;

    align-items: center;

    gap: 15px;

    margin: 2rem 0 1.2rem;

    color: #999;

    font-size: 13px;

}

.login-separator::before,
.login-separator::after {

    content: '';

    height: 1px;

    flex: 1;

    background: var(--line);

}


/* ========================================
   VOLTAR PARA LOGIN NORMAL
======================================== */

.voltar-login {

    text-align: center;

}

.voltar-login p {

    margin: 0 0 12px;

    color: #777;

    font-size: 14px;

}

.botao-secundario {

    width: 100%;

    padding: 0.85rem 1rem;

    border: 1px solid var(--mint-dark);

    border-radius: 0.75rem;

    background: #fff;

    color: var(--mint-dark);

    font: inherit;

    font-weight: 700;

    cursor: pointer;

    transition:
        background 0.2s,
        transform 0.2s;

}

.botao-secundario:hover {

    background: rgba(40, 114, 101, 0.06);

    transform: translateY(-1px);

}


/* ========================================
   SUPORTE
======================================== */

.support {

    margin-top: 30px;

    color: #888;

    font-size: 13px;

    text-align: center;

}

.support a {

    color: var(--mint-dark);

    font-weight: 700;

    text-decoration: none;

}

.support a:hover {

    text-decoration: underline;

}


/* ========================================
   RESPONSIVO
======================================== */

@media (max-width: 900px) {

    .login-page {

        grid-template-columns: 1fr;

    }

    .intro-panel {

        display: none;

    }

    .login-panel {

        min-height: 100vh;

        padding: 35px;

    }

}


@media (max-width: 500px) {

    .login-panel {

        padding: 25px 20px;

    }

}

</style>