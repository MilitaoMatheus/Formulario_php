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

function mascaraCPF(campo) {
    let valor = campo.value.replace(/\D/g, ""); // remove tudo que não for número

    if (valor.length > 3 && valor.length <= 6) {
        valor = valor.replace(/(\d{3})(\d+)/, "$1.$2");
    } else if (valor.length > 6 && valor.length <= 9) {
        valor = valor.replace(/(\d{3})(\d{3})(\d+)/, "$1.$2.$3");
    } else if (valor.length > 9) {
        valor = valor.replace(/(\d{3})(\d{3})(\d{3})(\d+)/, "$1.$2.$3-$4");
    }

    campo.value = valor;
}