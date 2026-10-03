<script setup>

import { useRouter } from 'vue-router'

const router = useRouter()


function irParaComandas() {

    router.push('/comandas')

}


function irParaProdutos() {

    router.push('/produtos')

}


function irParaRestaurante() {

    router.push('/restaurante')

}


function sair() {

    router.push('/login')

}

</script>


<template>

    <main class="home-container">

        <!-- HEADER -->

        <header class="home-header">

            <div class="logo-area">

                <div class="logo">

                    🍽️

                </div>

                <div>

                    <h1>

                        Meu Restaurante

                    </h1>

                    <span>

                        Sistema de gestão

                    </span>

                </div>

            </div>


            <button
                class="botao-sair"
                @click="sair"
            >

                Sair

            </button>

        </header>


        <!-- CONTEÚDO -->

        <section class="home-content">

            <div class="boas-vindas">

                <div>

                    <span class="titulo-pequeno">

                        PAINEL PRINCIPAL

                    </span>

                    <h2>

                        Olá, seja bem-vindo! 👋

                    </h2>

                    <p>

                        Gerencie seu restaurante de forma simples e rápida.

                    </p>

                </div>

            </div>


            <!-- RESUMO -->

            <div class="resumo">

                <div class="resumo-card">

                    <span class="resumo-icone">

                        🧾

                    </span>

                    <div>

                        <span class="resumo-titulo">

                            Comandas abertas

                        </span>

                        <strong>

                            0

                        </strong>

                    </div>

                </div>


                <div class="resumo-card">

                    <span class="resumo-icone">

                        📦

                    </span>

                    <div>

                        <span class="resumo-titulo">

                            Produtos

                        </span>

                        <strong>

                            0

                        </strong>

                    </div>

                </div>


                <div class="resumo-card">

                    <span class="resumo-icone">

                        💰

                    </span>

                    <div>

                        <span class="resumo-titulo">

                            Vendas hoje

                        </span>

                        <strong>

                            R$ 0,00

                        </strong>

                    </div>

                </div>

            </div>


            <!-- ACESSOS -->

            <section class="secao">

                <div class="secao-header">

                    <h3>

                        Acesso rápido

                    </h3>

                    <span>

                        Gerencie seu restaurante

                    </span>

                </div>


                <div class="atalhos">

                    <button
                        class="atalho"
                        @click="irParaComandas"
                    >

                        <span class="atalho-icone">

                            🧾

                        </span>

                        <div>

                            <strong>

                                Comandas

                            </strong>

                            <p>

                                Gerencie pedidos e mesas

                            </p>

                        </div>

                        <span class="seta">

                            →

                        </span>

                    </button>


                    <button
                        class="atalho"
                        @click="irParaProdutos"
                    >

                        <span class="atalho-icone">

                            📦

                        </span>

                        <div>

                            <strong>

                                Produtos

                            </strong>

                            <p>

                                Gerencie seu cardápio

                            </p>

                        </div>

                        <span class="seta">

                            →

                        </span>

                    </button>


                    <button
                        class="atalho"
                        @click="irParaRestaurante"
                    >

                        <span class="atalho-icone">

                            ⚙️

                        </span>

                        <div>

                            <strong>

                                Restaurante

                            </strong>

                            <p>

                                Configure seu restaurante

                            </p>

                        </div>

                        <span class="seta">

                            →

                        </span>

                    </button>

                </div>

            </section>

        </section>

    </main>

</template>


<style scoped>

* {
    box-sizing: border-box;
}


.home-container {

    min-height: 100vh;

    background: #f5f6f8;

    color: #222;

}


/* =========================
   HEADER
========================= */

.home-header {

    height: 76px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 0 45px;

    background: white;

    border-bottom: 1px solid #eeeeee;

}


.logo-area {

    display: flex;

    align-items: center;

    gap: 12px;

}


.logo {

    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #580b7c;

    font-size: 21px;

}


.logo-area h1 {

    margin: 0;

    color: #222;

    font-size: 17px;

    font-weight: 700;

}


.logo-area span {

    display: block;

    margin-top: 2px;

    color: #999;

    font-size: 12px;

}


.botao-sair {

    padding: 9px 18px;

    border: 1px solid #ddd;

    border-radius: 8px;

    background: white;

    color: #666;

    font-size: 14px;

    cursor: pointer;

    transition: 0.2s;

}


.botao-sair:hover {

    border-color: #580b7c;

    color: #580b7c;

}


/* =========================
   CONTEÚDO
========================= */

.home-content {

    width: 100%;

    max-width: 1100px;

    margin: 0 auto;

    padding: 45px 30px;

}


/* =========================
   BOAS VINDAS
========================= */

.boas-vindas {

    margin-bottom: 30px;

}


.titulo-pequeno {

    color: #580b7c;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 1px;

}


.boas-vindas h2 {

    margin: 7px 0 5px;

    font-size: 28px;

    color: #222;

}


.boas-vindas p {

    margin: 0;

    color: #777;

    font-size: 15px;

}


/* =========================
   RESUMO
========================= */

.resumo {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;

    margin-bottom: 40px;

}


.resumo-card {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 22px;

    background: white;

    border: 1px solid #eeeeee;

    border-radius: 12px;

}


.resumo-icone {

    width: 45px;
    height: 45px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f3eafa;

    font-size: 20px;

}


.resumo-titulo {

    display: block;

    margin-bottom: 4px;

    color: #888;

    font-size: 12px;

}


.resumo-card strong {

    color: #222;

    font-size: 20px;

}


/* =========================
   SEÇÃO
========================= */

.secao {

    margin-top: 10px;

}


.secao-header {

    margin-bottom: 15px;

}


.secao-header h3 {

    margin: 0 0 4px;

    color: #222;

    font-size: 18px;

}


.secao-header span {

    color: #999;

    font-size: 13px;

}


/* =========================
   ATALHOS
========================= */

.atalhos {

    display: flex;

    flex-direction: column;

    gap: 12px;

}


.atalho {

    width: 100%;

    display: flex;

    align-items: center;

    gap: 16px;

    padding: 18px 20px;

    border: 1px solid #eeeeee;

    border-radius: 12px;

    background: white;

    text-align: left;

    cursor: pointer;

    transition:
        transform 0.2s,
        box-shadow 0.2s,
        border-color 0.2s;

}


.atalho:hover {

    transform: translateY(-2px);

    border-color: #d9b9e5;

    box-shadow:
        0 6px 20px
        rgba(88, 11, 124, 0.08);

}


.atalho-icone {

    width: 44px;
    height: 44px;

    flex-shrink: 0;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f3eafa;

    font-size: 20px;

}


.atalho div {

    flex: 1;

}


.atalho strong {

    display: block;

    margin-bottom: 3px;

    color: #333;

    font-size: 15px;

}


.atalho p {

    margin: 0;

    color: #999;

    font-size: 12px;

}


.seta {

    color: #580b7c;

    font-size: 22px;

}


/* =========================
   RESPONSIVO
========================= */

@media (max-width: 700px) {

    .home-header {

        padding: 0 20px;

    }


    .home-content {

        padding: 30px 20px;

    }


    .resumo {

        grid-template-columns: 1fr;

    }


    .boas-vindas h2 {

        font-size: 24px;

    }

}

</style>