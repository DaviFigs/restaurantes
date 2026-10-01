<script setup>

const dados = defineModel()

const emit = defineEmits([
    'proximo'
])

</script>

<template>

    <form @submit.prevent="emit('proximo')">

        <div class="campo">

            <label for="nome_completo">
                Nome completo
            </label>

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

            <label for="email">
                E-mail
            </label>

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

            <label for="senha">
                Senha
            </label>

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


        <div class="linha">

            <div class="campo">

                <label for="cpf">
                    CPF
                </label>

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

                <label for="telefone">
                    Telefone
                </label>

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


        <button
            type="submit"
            class="botao principal"
        >
            Próximo →
        </button>

    </form>

</template>


<style scoped>

.campo {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
}

.campo label {
    margin-bottom: 7px;

    font-size: 14px;
    font-weight: 600;

    color: #333;
}

.campo input {
    width: 100%;

    padding: 12px 13px;

    border: 1px solid #d5d5d5;
    border-radius: 8px;

    outline: none;

    font-size: 15px;

    transition: 0.2s;
}

.campo input:focus {
    border-color: #580b7c;

    box-shadow:
        0 0 0 3px rgba(88, 11, 124, 0.1);
}

.linha {
    display: flex;
    gap: 15px;
}

.linha .campo {
    flex: 1;
}

.botao {
    width: 100%;

    padding: 13px;

    border: none;
    border-radius: 8px;

    font-size: 15px;
    font-weight: 600;

    cursor: pointer;
}

.principal {
    background: #580b7c;
    color: white;
}

.principal:hover {
    background: #480966;
}

@media (max-width: 600px) {

    .linha {
        flex-direction: column;
        gap: 0;
    }

}

</style>