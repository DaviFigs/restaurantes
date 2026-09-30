const API_URL =
    import.meta.env.VITE_API_URL ||
    'http://localhost:8000/ws/services.php'

export async function api(servico, data = {}, head = {}) {

    const payload = {
        dados: {
            head: {
                ...head,
                servico
            },

            data
        }
    }

    const resposta = await fetch(API_URL, {
        method: 'POST',

        headers: {
            'Content-Type': 'application/json'
        },

        credentials: 'include',

        body: JSON.stringify(payload)
    })

    if (!resposta.ok) {
        throw new Error(
            `Erro HTTP: ${resposta.status}`
        )
    }

    return await resposta.json()
}