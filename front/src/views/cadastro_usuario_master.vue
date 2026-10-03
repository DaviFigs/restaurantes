<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'

import UsuarioMasterForm from '../components/cadastro/form_usuario_master.vue'
import { cadastrar_usuario_master } from '../services/usuario_master.js'

const router = useRouter()

const carregando = ref(false)
const erro = ref('')

const dados = reactive({
  nome_completo: '',
  email: '',
  senha: '',
  cpf: '',
  telefone: '',
  data_nascimento: ''
})

async function cadastrar() {
  erro.value = ''
  carregando.value = true

  try {
    const resposta = await cadastrar_usuario_master(dados)
    const info = resposta?.info?.[0]

    if (!info || info.cdg_erro !== 0) {
      throw new Error(info?.msg || 'Erro ao cadastrar usuário master.')
    }

    router.push('/login')
  } catch (error) {
    erro.value = error?.message || 'Erro ao realizar cadastro.'
  } finally {
    carregando.value = false
  }
}
</script>

<template>
  <main class="login-page cadastro-page">
    <section class="intro-panel">
      <div class="brand-mark">TM</div>

      <p class="eyebrow">Tá na Mesa</p>

      <h1>Abra sua conta e transforme sua operação.</h1>

      <p class="intro-copy">
        Cadastre seu usuário e tenha acesso ao controle completo do seu restaurante,
        do atendimento ao financeiro e à operação.
      </p>

      <div class="signal-list" aria-label="Recursos do sistema">
        <span><i></i> Cadastro rápido e seguro</span>
        <span><i></i> Acesso ao painel do restaurante</span>
        <span><i></i> Gestão centralizada em um só lugar</span>
      </div>
    </section>

    <section class="login-panel" aria-labelledby="cadastro-title">
      <div class="login-heading">
        <p class="eyebrow">Crie sua conta e cadastre seu restaurante</p>
        <h2 id="cadastro-title">Usuário Chefe</h2>
        <p>Preencha os dados para começar.</p>
      </div>

      <UsuarioMasterForm
        v-model="dados"
        :loading="carregando"
        @cadastrar="cadastrar"
      />

      <p v-if="erro" class="feedback error" role="alert">
        {{ erro }}
      </p>

      <p v-if="carregando" class="feedback success" role="status">
        Cadastrando...
      </p>

      <p class="support">
        Já possui conta?
        <router-link to="/login">Entrar agora</router-link>
      </p>
    </section>
  </main>
</template>

<style scoped>
.cadastro-page .login-panel {
  max-width: 38rem;
}

.cadastro-page .login-heading h2 {
  margin-bottom: 0.5rem;
}

.cadastro-page .support {
  margin-top: 2rem;
}
</style>