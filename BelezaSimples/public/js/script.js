document.addEventListener('DOMContentLoaded', listarServicos);

const form = document.getElementById('formServico');
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('id').value;
    const dados = new FormData(form);
    dados.append('acao', id ? 'atualizar' : 'cadastrar');

    fetch('controllers/ServicoController.php', {
        method: 'POST',
        body: dados
    })
    .then(res => res.json())
    .then(() => {
        form.reset();
        listarServicos();
    });
});

function listarServicos() {
    fetch('controllers/ServicoController.php?acao=listar')
        .then(res => res.json())
        .then(dados => {
            const tabela = document.getElementById('tabelaServicos');
            tabela.innerHTML = '';
            dados.forEach(servico => {
                tabela.innerHTML += `
                    <tr>
                        <td>${servico.id}</td>
                        <td>${servico.nome}</td>
                        <td>${servico.descricao}</td>
                        <td>${servico.icone}</td>
                        <td>
                            <button onclick="editar(${servico.id})">Editar</button>
                            <button onclick="excluir(${servico.id})">Excluir</button>
                        </td>
                    </tr>
                `;
            });
        });
}

function editar(id) {
    fetch(`controllers/ServicoController.php?acao=buscar&id=${id}`)
        .then(res => res.json())
        .then(dados => {
            document.getElementById('id').value = dados.id;
            document.getElementById('nome').value = dados.nome;
            document.getElementById('descricao').value = dados.descricao;
            document.getElementById('icone').value = dados.icone;
        });
}

function excluir(id) {
    if (confirm('Deseja realmente excluir este serviço?')) {
        const dados = new FormData();
        dados.append('acao', 'excluir');
        dados.append('id', id);

        fetch('controllers/ServicoController.php', {
            method: 'POST',
            body: dados
        })
        .then(res => res.json())
        .then(() => listarServicos());
    }
}
