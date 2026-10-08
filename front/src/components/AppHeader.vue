<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function sair() {
  router.push('/login')
}

const sessao = JSON.parse(
    localStorage.getItem('sessao_usuario')
)

console.log(sessao)

</script>

<template>
  <header class="app-header">
    <div class="header-content">
      <div class="brand" aria-label="Meu Restaurante">
        <span class="brand-icon" aria-hidden="true">🍽️</span>
      </div>

      <nav class="main-nav" aria-label="Navegação principal">
        <RouterLink to="/" exact-active-class="active-link">Dashboard</RouterLink>
        <RouterLink to="/" active-class="active-link">Usuários</RouterLink>
        <RouterLink to="/" active-class="active-link">Vendas</RouterLink>
      </nav>

      <button class="botao-sair" type="button" @click="sair">
        Sair
      </button>
    </div>
  </header>
</template>

<style scoped>
.app-header {
  position: relative;
  z-index: 1;
  background: #fff;
  border-bottom: 1px solid #dce7e2;
  box-shadow: 0 3px 14px rgba(21, 45, 43, 0.05);
}

.header-content {
  width: min(100% - 2.5rem, 1160px);
  min-height: 72px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1.5rem;
}

.brand {
  display: inline-flex;
  align-items: center;
  gap: 0.65rem;
  color: #152d2b;
  font-weight: 700;
  white-space: nowrap;
}

.brand-icon {
  width: 2.4rem;
  height: 2.4rem;
  display: grid;
  place-items: center;
  border-radius: 0.75rem;
  background: #e7f4ee;
  font-size: 1.2rem;
}

.main-nav {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.35rem;
}

.main-nav a {
  padding: 0.65rem 0.9rem;
  border-radius: 0.6rem;
  color: #526661;
  font-size: 0.92rem;
  font-weight: 600;
  text-decoration: none;
  transition: background 0.2s, color 0.2s;
}

.main-nav a:hover,
.main-nav a.active-link {
  background: #e7f4ee;
  color: #287265;
}

.botao-sair {
  width: auto;
  margin: 0;
  padding: 0.48rem 0.8rem;
  border: 1px solid #dce7e2;
  border-radius: 0.55rem;
  background: #fff;
  color: #526661;
  font: inherit;
  font-size: 0.82rem;
  font-weight: 600;
  cursor: pointer;
  transition: border-color 0.2s, color 0.2s, background 0.2s;
}

.botao-sair:hover {
  transform: none;
  border-color: #287265;
  background: #f3faf6;
  color: #287265;
}

@media (max-width: 620px) {
  .header-content {
    width: min(100% - 1.5rem, 1160px);
    min-height: 64px;
    gap: 0.5rem;
  }

  .brand {
    gap: 0.4rem;
    font-size: 0.85rem;
  }

  .brand-icon {
    width: 2rem;
    height: 2rem;
  }

  .main-nav {
    gap: 0;
  }

  .main-nav a {
    padding: 0.55rem 0.45rem;
    font-size: 0.8rem;
  }

  .botao-sair {
    padding: 0.42rem 0.55rem;
    font-size: 0.75rem;
  }
}

@media (max-width: 390px) {
  .brand span:last-child {
    display: none;
  }
}
</style>
