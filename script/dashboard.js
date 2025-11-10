document.addEventListener("DOMContentLoaded", async () => {
    try{
        const response = await fetch("../models/dashboard_model.php");
        if(!response.ok) throw new Error("Erro ao buscar dados no dashboard");

        const data = await response.json();

        document.getElementById("totalReceitas").textContent = `RS ${parseFloat(data.total_receitas || 0).toFixed(2)}`;
        document.getElementById("totalDespesas").textContent = `RS ${parseFloat(data.total_despesas || 0).toFixed(2)}`;
        document.getElementById("saldoTotal").textContent = `RS ${parseFloat(data.saldo_total || 0).toFixed(2)}`;

        //Crição do gráfico
        const ctx = document.getElementById("graficoPizza");
        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Receitas", "Despesas"],
                datasets: [{
                    data: [data.total_receitas, data.total_despesas],
                    backgroundColor: ["#32CD32", "#FF6347"],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    },
                    title: {
                        display: true,
                        text: "Distribuição financeira"
                    }
                }
            }
        });
    } catch (error){
        console.error(error);
        alert("Falha ao carregar dados do dashboard");
    }
})