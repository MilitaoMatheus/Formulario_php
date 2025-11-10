document.addEventListener("DOMContentLoaded", async () => {
    const nomeUsuario = document.getElementById("nomeUsuario");
    const emailUsuario = document.getElementById("emailUsuario");
    const nascimentoUsuario = document.getElementById("nascimentoUsuario");

    const btnEditar = document.getElementById("btnEditar");
    const btnSalvar = document.getElementById("btnSalvar");
    const btnCancelar = document.getElementById("btnCancelar");

    // Função para carregar os dados do perfil
    async function carregarPerfil() {
        try {
            const response = await fetch("../models/listar_perfil.php");
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

            const data = await response.json();
            if (data.erro) {
                alert(data.erro);
                return;
            }

            const dataFormatada = data.data_nasc ? data.data_nasc.split("T")[0] : "";

            nomeUsuario.textContent = data.nome_usuario || "—";
            emailUsuario.textContent = data.email_usuario || "—";
            nascimentoUsuario.textContent = dataFormatada || "—";
        } catch (error) {
            console.error("Erro ao carregar perfil:", error);
            alert("Falha ao carregar informações do perfil.");
        }
    }

    // chama ao iniciar
    await carregarPerfil();

    // editar
    btnEditar.addEventListener("click", () => {
        btnEditar.classList.add("hidden");
        btnSalvar.classList.remove("hidden");
        btnCancelar.classList.remove("hidden");

        trocarParaInput(nomeUsuario, "text");
        trocarParaInput(emailUsuario, "email");
        trocarParaInput(nascimentoUsuario, "date");
    });

    // salvar alterações
    btnSalvar.addEventListener("click", async () => {
        const inputNome = nomeUsuario.querySelector("input");
        const inputEmail = emailUsuario.querySelector("input");
        const inputNasc = nascimentoUsuario.querySelector("input");

        const dadosAtualizados = {
            nome_usuario: inputNome ? inputNome.value.trim() : nomeUsuario.textContent.trim(),
            email_usuario: inputEmail ? inputEmail.value.trim() : emailUsuario.textContent.trim(),
            data_nasc: inputNasc ? inputNasc.value : (nascimentoUsuario.textContent || "")
        };

        try {
            const response = await fetch("../models/atualizar_perfil.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(dadosAtualizados)
            });

            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

            const resultado = await response.json();

            if (resultado.sucesso) {
                alert("Perfil atualizado com sucesso!");
                await carregarPerfil(); // atualiza a UI sem reload
                btnSalvar.classList.add("hidden");
                btnCancelar.classList.add("hidden");
                btnEditar.classList.remove("hidden");
            } else {
                alert("Erro: " + (resultado.erro || "Falha ao atualizar o perfil."));
            }
        } catch (error) {
            console.error("Erro na requisição:", error);
            alert("Falha na comunicação com o servidor.");
        }
    });

    // edição
    btnCancelar.addEventListener("click", async () => {
        await carregarPerfil();
        btnSalvar.classList.add("hidden");
        btnCancelar.classList.add("hidden");
        btnEditar.classList.remove("hidden");
    });

    function trocarParaInput(elemento, tipo) {
        const valorAtualRaw = elemento.textContent.trim();
        const valorInicial = valorAtualRaw === "—" ? "" : valorAtualRaw;

        elemento.innerHTML = `<input type="${tipo}" value="${valorInicial}" class="input-edit" id="${elemento.id}_input">`;
    }
});
