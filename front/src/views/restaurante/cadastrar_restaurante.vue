<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'

import RestauranteForm from '../../components/cadastro/form_restaurante.vue'
import { cadastrar_restaurante } from '../../services/restaurante.js'

const router = useRouter()

const carregando = ref(false)
const erro = ref('')

const sessao = JSON.parse(
    localStorage.getItem('sessao_master') || '{}'
)

const restaurante = reactive({
    id_usuario_master: sessao?.id_usuario_master || '',
    nome: '',
    login_restaurante: '',
    cpf_cnpj: '',
    email: '',
    telefone: ''
})

const endereco = reactive({
    cep: '',
    logradouro: '',
    numero: '',
    complemento: '',
    bairro: '',
    cidade: '',
    estado: ''
})

async function cadastrar() {
    erro.value = ''
    carregando.value = true

    try {
        if (!restaurante.id_usuario_master) {
            throw new Error('Sessão do usuário master não encontrada. Faça login novamente.')
        }

        const resposta = await cadastrar_restaurante({
            restaurante: { ...restaurante },
            endereco: { ...endereco }
        })

        const info = resposta?.info?.[0]

        if (!info || info.cdg_erro !== 0) {
            throw new Error(info?.msg || 'Erro ao cadastrar restaurante.')
        }

        router.push('/home_master')
    } catch (error) {
        erro.value = error?.message || 'Erro ao cadastrar restaurante.'
    } finally {
        carregando.value = false
    }
}
</script>

<template>
    <main class="cadastro-restaurante-page">
        <section class="cadastro-restaurante-card">
            <div class="cabecalho">
                <span class="eyebrow">Cadastro de restaurante</span>
                <h1>Preencha os dados do seu negócio</h1>
                <p>Cadastre a identidade e o endereço do seu restaurante para começar a operação.</p>
            </div>

            <RestauranteForm
                v-model:restaurante="restaurante"
                v-model:endereco="endereco"
                :loading="carregando"
                @voltar="router.push('/home_master')"
                @cadastrar="cadastrar"
            />

            <p v-if="erro" class="feedback error" role="alert">
                {{ erro }}
            </p>

            <p v-if="carregando" class="feedback success" role="status">
                Cadastrando restaurante...
            </p>
        </section>
    </main>
</template>

<style scoped>
.cadastro-restaurante-page {
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem 3rem;
    background: linear-gradient(135deg, #f4f7f6 0%, #eef5f4 100%);
}

.cadastro-restaurante-card {
    width: min(100%, 58rem);
    background: #fff;
    border: 1px solid #e7ebe9;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(31, 52, 47, 0.08);
    padding: 2rem;
}

.cabecalho {
    margin-bottom: 1.75rem;
}

.eyebrow {
    display: inline-block;
    margin-bottom: .75rem;
    color: #1d5c51;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.cabecalho h1 {
    margin: 0;
    color: #1d1d1d;
    font-size: clamp(1.8rem, 3vw, 2.5rem);
}

.cabecalho p {
    margin: .8rem 0 0;
    color: #5d6b68;
    font-size: 1rem;
    line-height: 1.6;
}

.feedback {
    margin-top: 1rem;
    padding: .8rem 1rem;
    border-radius: 10px;
    font-size: .96rem;
}

.feedback.error {
    background: #fff0f0;
    color: #b42318;
    border: 1px solid #f7c7c7;
}

.feedback.success {
    background: #eefbf5;
    color: #127e4e;
    border: 1px solid #cceadf;
}

@media (max-width: 600px) {
    .cadastro-restaurante-card {
        padding: 1.25rem;
    }
}
</style>