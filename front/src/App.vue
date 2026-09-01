<script setup>
import { ref } from 'vue'

const restaurante = ref('')
const usuario = ref('')
const senha = ref('')
const carregando = ref(false)
const erro = ref('')
const sucesso = ref('')

const endpoint = import.meta.env.VITE_API_URL || 'http://localhost:8000/ws/services.php'

async function autenticar() {
  erro.value = ''
  sucesso.value = ''
  carregando.value = true

  try {
    const resposta = await fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        dados: {
          head: { chave: '', servico: 'autenticacao' },
          data: {
            restaurante: restaurante.value.trim(),
            usuario: usuario.value.trim(),
            senha: senha.value,
          },
        },
      }),
    })

    if (!resposta.ok) throw new Error(`Serviço indisponível (${resposta.status})`)

    const resultado = await resposta.json()
    const info = resultado.info?.[0]

    if (!info || info.cdg_erro !== 0) {
      throw new Error(info?.msg || 'Não foi possível realizar o acesso.')
    }

    if (resultado.dados) localStorage.setItem('crm-sessao', JSON.stringify(resultado.dados))
    sucesso.value = info.msg || 'Autenticação realizada com sucesso.'
  } catch (error) {
    erro.value = error instanceof TypeError
      ? 'Não foi possível conectar ao serviço de autenticação.'
      : error.message
  } finally {
    carregando.value = false
  }
}
</script>

<template>
  <main class="login-page">
    <section class="intro-panel">
      <div class="brand-mark">CI</div>
      <p class="eyebrow">CRM inteligente</p>
      <h1>Seu restaurante, mais organizado.</h1>
      <p class="intro-copy">Acompanhe sua operação com clareza e tome decisões melhores todos os dias.</p>
      <div class="signal-list" aria-label="Recursos do sistema">
        <span><i></i> Gestão centralizada</span>
        <span><i></i> Operação em tempo real</span>
      </div>
    </section>

    <section class="login-panel" aria-labelledby="login-title">
      <div class="login-heading">
        <p class="eyebrow">Bem-vindo de volta</p>
        <h2 id="login-title">Acessar sua conta</h2>
        <p>Entre com seus dados para continuar.</p>
      </div>

      <form @submit.prevent="autenticar">
        <label for="restaurante">Restaurante</label>
        <input id="restaurante" v-model="restaurante" name="restaurante" autocomplete="organization" placeholder="Nome do restaurante" required />

        <label for="usuario">Usuário</label>
        <input id="usuario" v-model="usuario" name="usuario" autocomplete="username" placeholder="Digite seu usuário" required />

        <label for="senha">Senha</label>
        <input id="senha" v-model="senha" name="senha" type="password" autocomplete="current-password" placeholder="Digite sua senha" required />

        <p v-if="erro" class="feedback error" role="alert">{{ erro }}</p>
        <p v-if="sucesso" class="feedback success" role="status">{{ sucesso }}</p>

        <button type="submit" :disabled="carregando">
          {{ carregando ? 'Conectando...' : 'Entrar' }}
          <span aria-hidden="true">→</span>
        </button>
      </form>
      <p class="support">Problemas para acessar? <a href="mailto:suporte@crminteligente.com">Fale com o suporte</a></p>
    </section>
  </main>
</template>
