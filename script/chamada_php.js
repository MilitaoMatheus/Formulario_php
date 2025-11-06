function mascaraTelefone(campo) {
    //Removendo o que não é digito
    let valor = campo.value.replace(/\D/g, "");

    //Adicionando os parêntese nos primeiros números
    if (valor.length > 2) {
        valor = "(" + valor.substring(0, 2) + ") " + valor.substring(2);
    }

    //Adicionando o '-' antes dos últimos digitos
    if (valor.length > 10) {
        valor = valor.substring(0, 10) + "-" + valor.substring(10, 14);
    }

    campo.value = valor;
}

document.getElementById('formCadastro').addEventListener('submit', async function (e) {
    e.preventDefault(); // Impede o recarregamento da página

    //Coletando as informações digitadas no forms
    const nome = document.getElementById('nome').value.trim();
    const cpf = document.getElementById('cpf').value.trim();
    const email = document.getElementById('email').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
    const data = document.getElementById('data').value;
    const senha = document.getElementById('senha').value;
    const confirmarSenha = document.getElementById('confirmarSenha').value;

    //Validaão de senha
    if (senha !== confirmarSenha) {
        alert('As senhas não coincidem!');
        return;
    }

    const dados = { nome, cpf, email, senha, confirmarSenha, telefone, data };

    //try/catch realizando a conexão do front com o back
    try {
        const response = await fetch('models/validar_cadastro.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },            
            body: JSON.stringify(dados)
        });

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const resultado = await response.json();
        console.log(resultado);

        if (resultado.status === 'ok') {
            alert('Cadastro realizado com sucesso!');
            document.getElementById('formCadastro').reset();
        } 
        else if (resultado.erros && Array.isArray(resultado.erros)) {
            // Caso o PHP retorne múltiplos erros
            alert('Erros encontrados:\n- ' + resultado.erros.join('\n- '));
        } 
        else {
            alert('Erro: ' + (resultado.erro || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Falha na comunicação com o servidor.');
    }
});