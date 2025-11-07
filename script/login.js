document.getElementById('formLogin').addEventListener('submit', async function (e) {
    e.preventDefault(); // Impede o recarregamento da página

    //Coletando as informações digitadas no forms
    const cpf = document.getElementById('cpf').value.trim();
    const senha = document.getElementById('senha').value;

    const dados = { cpf, senha };

    //try/catch realizando a conexão do front com o back
    try {
        const response = await fetch('../models/login_usuario.php', {
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
            alert('Login realizado com sucesso!');
            document.getElementById('formLogin').reset();
            window.location.href = resultado.redirect;
        } 
        else {
            alert('Erro: ' + (resultado.erro || 'CPF ou Senha incorretos'));
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Falha na comunicação com o servidor.');
    }
});