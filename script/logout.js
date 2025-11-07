document.getElementById('btnLogout').addEventListener('click', async () => {
    if (!confirm('Deseja realmente sair?')) return;

    try {
        const response = await fetch('../models/logout.php', { method: 'POST' });
        const resultado = await response.json();

        if (resultado.status === 'ok') {
            alert(resultado.mensagem);
            window.location.href = '../pages/login_usuario.html';
        } else {
            alert('Erro ao sair: ' + (resultado.erro || 'Tente novamente.'));
        }
    } catch (error) {
        console.error('Erro ao fazer logout:', error);
        alert('Falha na comunicação com o servidor.');
    }
});
