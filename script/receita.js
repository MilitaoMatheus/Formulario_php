document.addEventListener("DOMContentLoaded", () => {
    carregarCategorias();
    carregarReceitas();

    const form = document.getElementById("formDespesas"); // mesmo ID do HTML
    form.addEventListener("submit", salvarReceita);
});

async function carregarCategorias() {
    try {
        const resp = await fetch("../models/listar_categorias_receita.php");
        const data = await resp.json();

        const select = document.getElementById("categoria");
        select.innerHTML = '<option value="">Selecione...</option>';

        data.forEach(cat => {
            const opt = document.createElement("option");
            opt.value = cat.id_tipo_receita;
            opt.textContent = cat.nome_tipo_receita;
            select.appendChild(opt);
        });
    } catch (e) {
        console.error("Erro ao carregar categorias:", e);
    }
}

async function carregarReceitas() {
    try {
        const resp = await fetch("../models/listar_receitas.php");
        const data = await resp.json();

        const tabela = document.getElementById("tabelaDespesas");
        tabela.innerHTML = "";

        if (data.length === 0) {
            tabela.innerHTML = `<tr><td colspan="5">Nenhuma receita cadastrada.</td></tr>`;
            return;
        }

        data.forEach(item => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${item.categoria}</td>
                <td>R$ ${parseFloat(item.valor).toFixed(2)}</td>
                <td>${new Date(item.data_recebimento).toLocaleDateString("pt-BR")}</td>
                <td>
                    <button class="btn-editar" onclick="editarReceita(${item.id_receita})">Editar</button>
                    <button class="btn-excluir" onclick="excluirReceita(${item.id_receita})">Excluir</button>
                </td>
            `;
            tabela.appendChild(tr);
        });
    } catch (e) {
        console.error("Erro ao carregar receitas:", e);
    }
}

async function salvarReceita(e) {
    e.preventDefault();

    const id = document.getElementById("idDespesaEdicao").value;
    const valor = document.getElementById("valor").value;
    const categoria = document.getElementById("categoria").value;
    const data = document.getElementById("data").value;

    if (!valor || !categoria || !data) {
        alert("Preencha todos os campos corretamente.");
        return;
    }

    const url = id ? "../models/alterar_receita.php" : "../models/cadastrar_receita.php";
    const payload = { id, valor, categoria, data };

    try {
        const resp = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        });

        const result = await resp.json();

        if (result.status === "ok") {
            alert(result.mensagem);
            document.getElementById("formDespesas").reset();
            document.getElementById("idDespesaEdicao").value = "";
            carregarReceitas();
        } else {
            alert(result.erro || "Erro ao salvar receita.");
        }
    } catch (e) {
        console.error("Erro ao salvar receita:", e);
    }
}

async function editarReceita(id) {
    try {
        const resp = await fetch("../models/listar_receitas.php");
        const data = await resp.json();
        const receita = data.find(r => r.id_receita == id);

        if (!receita) {
            alert("Receita não encontrada.");
            return;
        }

        document.getElementById("idDespesaEdicao").value = receita.id_receita;
        document.getElementById("valor").value = receita.valor;
        document.getElementById("categoria").value = receita.id_tipo_receita;
        document.getElementById("data").value = receita.data_recebimento.split("T")[0];
    } catch (e) {
        console.error("Erro ao editar receita:", e);
    }
}

async function excluirReceita(id) {
    if (!confirm("Deseja realmente excluir esta receita?")) return;

    try {
        const resp = await fetch("../models/excluir_receita.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id })
        });

        const result = await resp.json();

        if (result.status === "ok") {
            alert(result.mensagem);
            carregarReceitas();
        } else {
            alert(result.erro || "Erro ao excluir receita.");
        }
    } catch (e) {
        console.error("Erro ao excluir receita:", e);
    }
}
