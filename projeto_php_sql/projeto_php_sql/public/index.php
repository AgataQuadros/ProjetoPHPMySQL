<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Tarefas</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
    <h1>Minhas Tarefas</h1>

    <!-- Formulário para adicionar nova tarefa -->
    <input type="text" id="novaTarefa" placeholder="Digite uma nova tarefa...">
    <button id="btnAdicionar">Adicionar</button>

    <!-- Lista de tarefas -->
    <ul id="listaTarefas"></ul>

    <script>
        // Função para buscar e exibir as tarefas
        async function carregarTarefas() {
            const resposta = await fetch("../api/listar.php"); //Faz uma requisição (pedido) para o servidor, pedindo os dados das tarefas
            const tarefas = await resposta.json(); //Converte a resposta do servidor para um objeto JavaScript (a partir de JSON).

            const lista = document.getElementById("listaTarefas"); //Procura um elemento no HTML que tem o id="listaTarefas".
            lista.innerHTML = ""; // Limpa antes de listar

            tarefas.forEach(t => { //Varredura das tarefas
                const li = document.createElement("li"); //Cria um item de lista
                li.textContent = t.titulo; //coloca o título na lista

                if (t.concluida == 1) {
                    li.style.textDecoration = "line-through"; //Riscar a tarefa
                }

                // Botão de concluir
                const btnConcluir = document.createElement("button"); //Cria o botão
                btnConcluir.textContent = t.concluida == 1 ? "Desfazer" : "Concluir"; //Operador ternário 
                btnConcluir.onclick = async () => { // programação assíncrona para o evento de click
                    //Requisição HTTP
                    await fetch("../api/atualizar.php", {
                        method: "POST",
                        body: JSON.stringify({ //body não aceita objetos, é preciso ser strings
                            id: t.id,
                            concluida: t.concluida == 1 ? 0 : 1 //Operador Ternário para caracterizar como concluído
                        })
                    });
                    carregarTarefas();
                };

                // Botão de editar
                const btnEditar = document.createElement("button"); //Cria um novo botão usando JavaScript. Ele ainda não aparece na tela
                btnEditar.textContent = "Editar"; //Define o texto dentro do botão como "Editar"
                btnEditar.onclick = async () => {
                    // Abre prompt para editar o texto
                    const novoTitulo = prompt("Editar tarefa:", t.titulo); //Abre uma caixa de diálogo (prompt) para digitar um novo nome
                    if (novoTitulo && novoTitulo.trim() !== "") {
                        await fetch("../api/editar.php", { //Faz a requisição
                            method: "POST",
                            body: JSON.stringify({
                                id: t.id, //Envio do id
                                titulo: novoTitulo //envio do título
                            })
                        });
                        carregarTarefas();
                    }
                };

                // Botão de excluir
                const btnExcluir = document.createElement("button"); //Cria um novo botão em HTML usando JavaScript.
                btnExcluir.textContent = "Excluir"; //Define o texto que aparece dentro do botão como "Excluir".
                btnExcluir.onclick = async () => { //será executada uma função assíncrona
                    await fetch("../api/excluir.php", { //Faz a requisição
                        method: "POST", //Envia dados para o servidor
                        body: JSON.stringify({ //body não aceita objetos, é preciso ser strings. está enviando um objeto com o id da tarefa a ser excluída
                            id: t.id
                        })
                    });
                    carregarTarefas();
                };

                // Adiciona tudo no item da lista
                li.append(" ", btnConcluir, " ", btnEditar, " ", btnExcluir);
                lista.appendChild(li);
            });

        }

        // Adicionar nova tarefa
        document.getElementById("btnAdicionar").onclick = async () => { //Procura um botão com o id="btnAdicionar"
            const titulo = document.getElementById("novaTarefa").value; //Pega o texto que o usuário digitou no campo de entrada (input)
            if (titulo.trim() === "") return; //Verifica se o usuário não digitou nada (ou só espaços em branco)

            await fetch("../api/adicionar.php", { //Envia a tarefa digitada para o servidor para salvar no banco de dados.
                method: "POST", //configura o método Posto para o envio
                body: JSON.stringify({ //Envia o título como texto
                    titulo
                })
            });

            document.getElementById("novaTarefa").value = ""; //Limpa o campo de texto após a tarefa ser adicionada.
            carregarTarefas(); //Recarrega a lista de tarefas
        };

        // Carrega ao abrir a página
        carregarTarefas();
    </script>
</body>

</html>

