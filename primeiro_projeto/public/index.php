<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tarefas</title>
</head>

<body>

    <h1>
        Minhas Tarefas
    </h1>

    <!-- Formulário para adicionar nova tarefa -->
    <input type="text" id="novaTarefa" placeholder="Digite uma nova tarefa...">
    <button id="btnAdicionar">Adicionar</button>

    <!-- Lista de Tarefas -->
    <ul id="listaTarefas"></ul>

    <script>

        // função para burcar e exibir as tarefas
        async function carregarTarefas() {
            const resposta = await fetch("../api/listar.php");
            const tarefas = await resposta.json();

            const lista = document.getElementById("listaTarefas");
            lista.innerHTML = ""; // Limpa antes de listar

            tarefas.forEach(t => {
                const li = document.createElement("li");
                li.textContent = t.titulo;

                if (t.concluida == 1) {
                    li.style.textDecoration = "line-through";
                }

                // Botão de concluir

                const btnConcluir = document.createElement("button");
                btnConcluir.textContent = t.concluida == 1 ? "Desfazer" : "Concluir";
                btnConcluir.onclick = async () => {
                    await fetch("../api/atualizar.php", {
                        method: "POST",
                        body: JSON.stringify({
                            id: t.id,
                            concluida: t.concluida == 1 ? 0 : 1
                        })
                    });
                    carregarTarefas();
                };

                // Botão de Editar

                const btnEditar = document.createElement("button");
                btnConcluir.textContent = "Editar";
                btnConcluir.onclick = async () => {
                    // Abre promt para editar texto
                    const novoTitulo = prompt("Editar tarefa:", t.titulo);
                    if(novoTitulo && novoTitulo.trim() !== "") {

                        await fetch("../api/editar.php", {
                            method: "POST",
                            body: JSON.stringify({
                                id: t.id,
                                titulo: novoTitulo
                            })
                        });
                        carregarTarefas();
                    }
                };


                //  Botão excluir

                const btnExcluir = document.createElement("button");
                btnExcluir.textContent = "Excluir";
                btnExcluir.onclick = async () => {
                    await fetch("../api/excluir.php", {
                        method: "POST",
                        body: JSON.stringify({
                            id: t.id
                        })
                    });
                    carregarTarefas();
                };

                li.append(" ", btnConcluir, " ", btnEditar, " ", btnExcluir);
                lista.appendChild(li);
            });

        }


        // Adiciona nova tarefa
        document.getElementById("btnAdicionar").onclick = async () => {
            const titulo = document.getElementById("novaTarefa").value;
            if(titulo.trim() === "") return;

            await fetch("../api/adicionar.php", {
                method: "POST",
                body: JSON.stringify({
                    titulo
                })
            });
            document.getElementById("novaTarefa").value = "";
            carregarTarefas();
        };

        // Carrega ao abrir a pagina
        carregarTarefas()

    </script>

</body>

</html>