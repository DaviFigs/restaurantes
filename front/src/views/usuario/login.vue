<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { autenticar } from '../../services/usuario.js'

const router = useRouter()

const restaurante = ref('')
const usuario = ref('')
const senha = ref('')

const carregando = ref(false)
const erro = ref('')
const sucesso = ref('')

async function fazerLogin() {
  erro.value = ''
  sucesso.value = ''
  carregando.value = true

  try {
    const resultado = await autenticar(
      restaurante.value.trim(),
      usuario.value.trim(),
      senha.value
    )

    const info = resultado.info?.[0]

    if (!info || info.cdg_erro !== 0) {
      throw new Error(
        info?.msg || 'Não foi possível realizar o acesso.'
      )
    }

    if (resultado.dados) {
      localStorage.setItem(
        'sessao_usuario',
        JSON.stringify(resultado.dados)
      )
    }

    sucesso.value =
      info.msg || 'Autenticação realizada com sucesso.'

    router.push('/home')

  } catch (error) {
    erro.value =
      error instanceof TypeError
        ? 'Não foi possível conectar ao serviço de autenticação.'
        : error.message

  } finally {
    carregando.value = false
  }
}

function irParaCadastro() {
  router.push('/cadastro')
}

function loginMaster() {
  router.push('/login_master')
}
</script>

<template>
  <main class="login-page">

    <section class="intro-panel">

      <div class="brand-mark">TM</div>

      <p class="eyebrow">Tá na Mesa</p>

      <h1>
        Seu restaurante,
        mais organizado.
      </h1>

      <p class="intro-copy">
        Acompanhe sua operação com clareza e
        tome decisões melhores todos os dias.
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
          Operação em tempo real
        </span>

        <span>
          <i></i>
          Controle de pedidos e comandas
        </span>

      </div>

    </section>


    <section
      class="login-panel"
      aria-labelledby="login-title"
    >

      <div class="login-heading">

        <p class="eyebrow">
          Bem-vindo de volta
        </p>

        <h2 id="login-title">
          Acesse sua conta e gerencie seu restaurante
        </h2>

        <p>
          Entre com seus dados para continuar.
        </p>

      </div>


      <form @submit.prevent="fazerLogin">

        <label for="restaurante">
          Restaurante
        </label>

        <input
          id="restaurante"
          v-model="restaurante"
          name="restaurante"
          autocomplete="organization"
          placeholder="Nome do restaurante"
          required
        />


        <label for="usuario">
          Usuário
        </label>

        <input
          id="usuario"
          v-model="usuario"
          name="usuario"
          autocomplete="username"
          placeholder="Digite seu usuário"
          required
        />


        <label for="senha">
          Senha
        </label>

        <input
          id="senha"
          v-model="senha"
          name="senha"
          type="password"
          autocomplete="current-password"
          placeholder="Digite sua senha"
          required
        />


        <p
          v-if="erro"
          class="feedback error"
          role="alert"
        >
          {{ erro }}
        </p>


        <p
          v-if="sucesso"
          class="feedback success"
          role="status"
        >
          {{ sucesso }}
        </p>


        <button
          type="submit"
          :disabled="carregando"
        >
          {{ carregando ? 'Conectando...' : 'Entrar' }}

          <span aria-hidden="true">
            →
          </span>
        </button>

      </form>
      <button
          type="button"
          class="botao-cadastro"
          @click="loginMaster"
        >
          Login Master (Configure e analise seu restaurante)
        </button>


      <div class="cadastro-separator">
        <span></span>
      </div>


      <div class="novo-restaurante">

        <p>
          Ainda não possui um restaurante ?
        </p>

        <button
          type="button"
          class="botao-cadastro"
          @click="irParaCadastro"
        >
          Cadastre-se e Crie Seu Restaurante
        </button>

      </div>


      <p class="support">
        Problemas para acessar?

        <a href="mailto:suporte@crminteligente.com">
          Fale com o suporte
        </a>
      </p>

    </section>

  </main>
</template>