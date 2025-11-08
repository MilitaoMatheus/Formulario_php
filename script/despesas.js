let despesas = [];
let modoEdicao = null;

document.addEventListener('DOMContentLoaded', () => {
    carregarCategorias();
    carregarPagamentos();
    listarDespesas();

    document.getElementById('formDespesas').addEventListener('submit', salvarDespesa);
});

async function listarDespesas() {
    const resp = await fetch('../models/listar_despesas.php');
    const dados = await resp.json();

    const tabela = document.getElementById('tabelaDespesas');
    tabela.innerHTML = '';

    if (!dados.length) {
        tabela.innerHTML = '<tr><td colspan="5">Nenhuma despesa encontrada.</td></tr>';
        return;
    }

    despesas = dados;
    dados.forEach(d => {
        tabela.innerHTML += `
            <tr>
                <td>${d.categoria}</td>
                <td>${parseFloat(d.valor).toFixed(2)}</td>
                <td>${d.data_pagamento}</td>
                <td>${d.metodo_pagamento ?? '-'}</td>
                <td>
                    <button onclick="editarDespesa(${d.id_despesa})">Editar</button>
                    <button onclick="excluirDespesa(${d.id_despesa})">Excluir</button>
                </td>
            </tr>
        `;
    });
}

async function carregarCategorias() {
    const resp = await fetch('../models/listar_categorias.php');
    const dados = await resp.json();
    const select = document.getElementById('categoria');

    select.innerHTML = '<option value="">Selecione...</option>';
    dados.forEach(c => {
        select.innerHTML += `<option value="${c.id_tipo_despesa}">${c.nome_tipo || c.nome_despesa}</option>`;
    });
}

async function carregarPagamentos() {
    const resp = await fetch('../models/listar_pagamentos.php');
    const dados = await resp.json();
    const select = document.getElementById('pagamento');

    select.innerHTML = '<option value="">Selecione...</option>';
    dados.forEach(p => {
        select.innerHTML += `<option value="${p.id_tipo_pagamento}">${p.metodo_pagamento}</option>`;
    });
}

function editarDespesa(id) {
    const despesa = despesas.find(d => d.id_despesa === id);
    if (!despesa) return;

    // Preenche os inputs do formulário com os dados da despesa
    document.getElementById('valor').value = parseFloat(despesa.valor).toFixed(2);
    document.getElementById('data').value = despesa.data_pagamento;
    document.getElementById('categoria').value = despesa.id_tipo_despesa;
    document.getElementById('pagamento').value = despesa.id_tipo_pagamento ?? '';

    // Seta modo de edição
    modoEdicao = id;

    // Muda o botão para indicar edição (opcional)
    const btn = document.querySelector('#formDespesas button[type="submit"]');
    if (btn) btn.textContent = 'Atualizar Despesa';
}

async function salvarDespesa(e) {
    e.preventDefault();

    const valor = document.getElementById('valor').value;
    const categoria = document.getElementById('categoria').value;
    const data = document.getElementById('data').value;
    const pagamento = document.getElementById('pagamento').value;

    if (!valor || !categoria || !data) {
        alert('Preencha todos os campos obrigatórios!');
        return;
    }

    const rota = modoEdicao ? '../models/alterar_despesa.php' : '../models/cadastrar_despesa.php';
    const body = { valor, categoria, data, pagamento };
    if (modoEdicao) body.id = modoEdicao;

    try {
        const resp = await fetch(rota, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(body)
        });

        const dataResp = await resp.json();
        alert(dataResp.mensagem || dataResp.erro);

        if (dataResp.status === 'ok') {
            document.getElementById('formDespesas').reset();
            modoEdicao = null;

            const btn = document.querySelector('#formDespesas button[type="submit"]');
            if (btn) btn.textContent = 'Cadastrar Despesa';

            listarDespesas();
        }
    } catch (error) {
        console.error('Erro ao salvar despesa:', error);
    }
}

async function excluirDespesa(id) {
    if (!confirm('Tem certeza que deseja excluir esta despesa?')) return;

    const resp = await fetch('../models/excluir_despesa.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    });

    const data = await resp.json();
    alert(data.mensagem || data.erro);
    if (data.status === 'ok') listarDespesas();
}
