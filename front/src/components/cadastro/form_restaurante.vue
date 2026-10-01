<script setup>

const restaurante = defineModel('restaurante')
const endereco = defineModel('endereco')

const emit = defineEmits([
    'voltar',
    'cadastrar'
])

</script>

<template>

    <form @submit.prevent="emit('cadastrar')">

        <!-- RESTAURANTE -->

        <div class="campo">

            <label for="nome_restaurante">
                Nome do restaurante
            </label>

            <input
                id="nome_restaurante"
                v-model="restaurante.nome"
                type="text"
                maxlength="50"
                placeholder="Ex.: Restaurante do Davi"
                required
            >

        </div>


        <div class="linha">

            <div class="campo">

                <label for="login_restaurante">
                    Login
                </label>

                <input
                    id="login_restaurante"
                    v-model="restaurante.login_restaurante"
                    type="text"
                    maxlength="30"
                    placeholder="meurestaurante"
                    required
                >

            </div>


            <div class="campo">

                <label for="cpf_cnpj">
                    CPF/CNPJ
                </label>

                <input
                    id="cpf_cnpj"
                    v-model="restaurante.cpf_cnpj"
                    type="text"
                    maxlength="30"
                    placeholder="CPF ou CNPJ"
                    required
                >

            </div>

        </div>


        <div class="linha">

            <div class="campo">

                <label for="email_restaurante">
                    E-mail
                </label>

                <input
                    id="email_restaurante"
                    v-model="restaurante.email"
                    type="email"
                    maxlength="100"
                    placeholder="restaurante@email.com"
                    required
                >

            </div>


            <div class="campo">

                <label for="telefone_restaurante">
                    Telefone
                </label>

                <input
                    id="telefone_restaurante"
                    v-model="restaurante.telefone"
                    type="tel"
                    maxlength="20"
                    placeholder="(67) 3333-3333"
                    required
                >

            </div>

        </div>


        <!-- ENDEREÇO -->

        <div class="separador">
            <span>Endereço</span>
        </div>


        <div class="linha">

            <div class="campo cep">

                <label for="cep">
                    CEP
                </label>

                <input
                    id="cep"
                    v-model="endereco.cep"
                    type="text"
                    maxlength="10"
                    placeholder="79000-000"
                    required
                >

            </div>


            <div class="campo">

                <label for="logradouro">
                    Logradouro
                </label>

                <input
                    id="logradouro"
                    v-model="endereco.logradouro"
                    type="text"
                    maxlength="50"
                    placeholder="Rua, avenida..."
                    required
                >

            </div>

        </div>


        <div class="linha">

            <div class="campo numero">

                <label for="numero">
                    Número
                </label>

                <input
                    id="numero"
                    v-model="endereco.numero"
                    type="text"
                    maxlength="10"
                    placeholder="123"
                    required
                >

            </div>


            <div class="campo">

                <label for="complemento">
                    Complemento
                </label>

                <input
                    id="complemento"
                    v-model="endereco.complemento"
                    type="text"
                    maxlength="50"
                    placeholder="Sala, loja..."
                >

            </div>

        </div>


        <div class="campo">

            <label for="bairro">
                Bairro
            </label>

            <input
                id="bairro"
                v-model="endereco.bairro"
                type="text"
                maxlength="50"
                placeholder="Centro"
                required
            >

        </div>


        <div class="linha">

            <div class="campo">

                <label for="cidade">
                    Cidade
                </label>

                <input
                    id="cidade"
                    v-model="endereco.cidade"
                    type="text"
                    maxlength="50"
                    placeholder="Campo Grande"
                    required
                >

            </div>


            <div class="campo estado">

                <label for="estado">
                    Estado
                </label>

                <input
                    id="estado"
                    v-model="endereco.estado"
                    type="text"
                    maxlength="2"
                    placeholder="MS"
                    required
                >

            </div>

        </div>


        <!-- BOTÕES -->

        <div class="botoes">

            <button
                type="button"
                class="botao voltar"
                @click="emit('voltar')"
            >
                ← Voltar
            </button>


            <button
                type="submit"
                class="botao cadastrar"
            >
                Cadastrar
            </button>

        </div>

    </form>

</template>


<style scoped>

.campo {
    display: flex;
    flex-direction: column;

    flex: 1;

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

.cep {
    flex: 0 0 130px;
}

.numero {
    flex: 0 0 120px;
}

.estado {
    flex: 0 0 80px;
}


/* SEPARADOR */

.separador {
    display: flex;
    align-items: center;

    gap: 15px;

    margin: 25px 0 20px;

    color: #777;

    font-size: 14px;
    font-weight: 600;
}

.separador::before,
.separador::after {
    content: '';

    height: 1px;

    flex: 1;

    background: #ddd;
}


/* BOTÕES */

.botoes {
    display: flex;
    gap: 12px;

    margin-top: 10px;
}

.botao {
    padding: 13px 20px;

    border: none;
    border-radius: 8px;

    font-size: 15px;
    font-weight: 600;

    cursor: pointer;
}

.voltar {
    width: 120px;

    background: #eeeeee;
    color: #444;
}

.cadastrar {
    flex: 1;

    background: #580b7c;
    color: white;
}

.cadastrar:hover {
    background: #480966;
}

@media (max-width: 600px) {

    .linha {
        flex-direction: column;
        gap: 0;
    }

    .cep,
    .numero,
    .estado {
        flex: 1;
    }

}

</style>