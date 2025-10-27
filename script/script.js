function mascaraTelefone(campo) {
    //Removendo o qque não é digito
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