<script setup>
const dados = defineModel()
const props = defineProps({
  loading: Boolean
})

const emit = defineEmits(['cadastrar'])
</script>

<template>
  <form class="auth-form" @submit.prevent="emit('cadastrar')">
    <div class="campo">
      <label for="nome_completo">Nome completo</label>
      <input
        id="nome_completo"
        v-model="dados.nome_completo"
        type="text"
        maxlength="100"
        placeholder="Digite seu nome completo"
        autocomplete="name"
        required
      >
    </div>

    <div class="campo">
      <label for="email">E-mail</label>
      <input
        id="email"
        v-model="dados.email"
        type="email"
        maxlength="100"
        placeholder="seu@email.com"
        autocomplete="email"
        required
      >
    </div>

    <div class="campo">
      <label for="data_nascimento">Data de nascimento</label>
      <input
        id="data_nascimento"
        v-model="dados.data_nascimento"
        type="date"
        required
      >
    </div>

    <div class="campo">
      <label for="senha">Senha</label>
      <input
        id="senha"
        v-model="dados.senha"
        type="password"
        maxlength="256"
        placeholder="Digite sua senha"
        autocomplete="new-password"
        required
      >
    </div>

    <div class="field-row">
      <div class="campo">
        <label for="cpf">CPF</label>
        <input
          id="cpf"
          v-model="dados.cpf"
          type="text"
          maxlength="11"
          placeholder="00000000000"
          inputmode="numeric"
          required
        >
      </div>

      <div class="campo">
        <label for="telefone">Telefone</label>
        <input
          id="telefone"
          v-model="dados.telefone"
          type="tel"
          maxlength="20"
          placeholder="(67) 99999-9999"
          autocomplete="tel"
          required
        >
      </div>
    </div>

    <button type="submit" class="botao-cadastro" :disabled="props.loading">
      {{ props.loading ? 'Cadastrando...' : 'Cadastrar' }}
      <span aria-hidden="true">→</span>
    </button>
  </form>
</template>

<style scoped>
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
  border: 1px solid var(--line);
  background: #fff;
  color: var(--ink);
  padding: 0.95rem 1rem;
  font: inherit;
  outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.campo input:focus {
  border-color: var(--mint-dark);
  box-shadow: 0 0 0 3px rgba(40, 114, 101, 0.12);
}

.field-row {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1rem;
}

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
  transition: background 0.2s, transform 0.2s, opacity 0.2s;
}

.botao-cadastro:hover:not(:disabled) {
  background: #1d5c51;
  transform: translateY(-2px);
}

.botao-cadastro:disabled {
  opacity: 0.65;
  cursor: wait;
}

@media (max-width: 600px) {
  .field-row {
    grid-template-columns: 1fr;
  }
}
</style>