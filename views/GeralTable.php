<?php
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = $this->deleteById($id);
}
if (!empty($this->data)) {
    $key = array_keys($this->data['data'][0]);
}


?>
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmação de exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Tem certeza de que deseja excluir o registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmButton" onclick="confirmarExclusao()">Excluir</button>
            </div>
        </div>
    </div>
</div>



<div id="error-message" class="alert alert-danger" style="display: none;"></div>
<div id="success-message" class="alert alert-success" style="display: none;"></div>
<div class="table-responsive">

    <h3><?= $this->data2['title']; ?></h3>
    <table class="table table-striped" id="dataTable">
        <thead>
            <tr>
                <?php if (!empty($this->data)) foreach ($key as $row) : ?>
                    <?php echo "<th>$row</th>" ?>
                <?php endforeach; ?>
                <?php if (!empty($this->data2[0])) foreach ($this->data2[0] as $row) : ?>
                    <?php echo "<th>$row</th>" ?>
                <?php endforeach; ?>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($this->data)) foreach ($this->data['data'] as $row) : ?>
                <tr>
                    <?php if (!empty($this->data)) foreach ($key as $rowkey) : ?>
                        <?php echo "<td>$row[$rowkey]</td>"; ?>
                    <?php endforeach; ?>
                    <td>
                        <div class='btn-group' role='group'>
                            <a href="http://localhost/projeto_php/<?php echo $this->data2['title']; ?>/cadastrar?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1.5 1.5 0 0 1-1.06.44H2.5a1 1 0 0 1-1-1V12a1 1 0 0 1 .44-1.06l9-9zM12 2l2 2-9 9H3V6l9-9z" />
                                    <path fill-rule="evenodd" d="M11.646 5.354a.5.5 0 0 1 0 .707L6.707 11H5v-1.707l5.646-5.647a.5.5 0 0 1 .708 0z" />
                                </svg>
                            </a>
                            <button onclick="excluir(<?php echo $row['id'] ?>)" class='btn btn-danger btn-sm'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                    <path d='M2.5 5.5A1.5 1.5 0 0 1 4 4h8a1.5 1.5 0 0 1 1.5 1.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 2.5 14v-9zm2-1v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5z' />
                                    <path fill-rule='evenodd' d='M4.5 1.5A.5.5 0 0 1 5 1h6a.5.5 0 0 1 .5.5V3h-7v-.5zM1 4v1.5A1.5 1.5 0 0 0 2.5 7H4V4H1zm12 0v3h1.5A1.5 1.5 0 0 0 15 6.5V4h-3zm-3 10h4a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5z' />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (empty($this->data['data'])) echo '<h4>Sem Registros</h4>'; ?>
</div>
<nav>
    <ul class="pagination">
        <?php if ($this->data['currentPage'] > 1) : ?>
            <li class="page-item">
                <a class="page-link" href="#" onclick="handlePagination(<?php echo $this->currentPage - 1; ?>)">Anterior</a>
            </li>
        <?php endif; ?>

        <?php
        $totalPages = ceil($this->data['totalCount'] / $this->data['limit']);

        for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo ($i == $this->currentPage ? 'active' : ''); ?>">
                <a class="page-link" href="#" onclick="handlePagination(<?php echo $i; ?>)"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($this->currentPage < $totalPages) : ?>
            <li class="page-item">
                <a class="page-link" href="#" onclick="handlePagination(<?php echo $this->data['currentPage'] + 1; ?>)">Próxima</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<a href="http://localhost/projeto_php/<?= $this->data2['title']; ?>/cadastrar" class="btn btn-primary">Ir para o cadastro</a>

<script>
    function excluir(id) {
        $('#confirmModal').modal('show');
        localStorage.setItem('id', JSON.stringify(id))
        console.log(localStorage.getItem('id'))
    }

    document.addEventListener('DOMContentLoaded', function() {
        var errorMessageElement = document.getElementById('<?php echo $res['error'] ? 'error' : 'success' ?>-message');
        var errorMessage = '<?php if (!empty($res)) {
                                echo $res['error'] ? $res['error'] : $res['success'];
                            } ?>';

        if (errorMessage !== '') {
            errorMessageElement.innerText = errorMessage;
            errorMessageElement.style.display = 'block';
            errorMessageElement.classList.add('show');

            setTimeout(function() {
                errorMessageElement.classList.remove('show');
                errorMessageElement.style.display = 'none';
            }, 2000);
        }
    })

    function confirmarExclusao() {
        if (localStorage.getItem('id')) {
            let id = JSON.parse(localStorage.getItem('id'))
            window.location.href = `http://localhost/projeto_php/<?= strtolower($this->data2['title']); ?>?id=${id}`;
        }
    }

    function handlePagination(page) {
        axios
            .get(`/projeto_php/views/consultar_<?= $this->data2['title']; ?>.php?compra=${page}`)
            .then(function(response) {
                var data = response.data;
                var tableBody = '';
                data.forEach(function(row) {
                    tableBody += '<tr>';
                    <?php if (!empty($this->data)) foreach ($key as $rowkey) : ?>
                        tableBody += '<td>' + row['<?= $rowkey ?>'] + '</td>';
                    <?php endforeach; ?>
                    tableBody += '<td>';
                    tableBody += '<div class="btn-group" role="group">';
                    tableBody +=
                        '<a href="http://localhost/projeto_php/<?= $this->data2['title']; ?>/cadastrar?id=' +
                        row['id'] +
                        '" class="btn btn-primary btn-sm">';
                    tableBody +=
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">' +
                        '<path d="M12.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1.5 1.5 0 0 1-1.06.44H2.5a1 1 0 0 1-1-1V12a1 1 0 0 1 .44-1.06l9-9zM12 2l2 2-9 9H3V6l9-9z"/>' +
                        '<path fill-rule="evenodd" d="M11.646 5.354a.5.5 0 0 1 0 .707L6.707 11H5v-1.707l5.646-5.647a.5.5 0 0 1 .708 0z"/>' +
                        '</svg>' +
                        '</a>';
                    tableBody +=
                        '<button onclick="excluir(' + row['id'] + ')" class="btn btn-danger btn-sm">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">' +
                        '<path d="M2.5 5.5A1.5 1.5 0 0 1 4 4h8a1.5 1.5 0 0 1 1.5 1.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 2.5 14v-9zm2-1v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5z"/>' +
                        '<path fill-rule="evenodd" d="M4.5 1.5A.5.5 0 0 1 5 1h6a.5.5 0 0 1 .5.5V3h-7v-.5zM1 4v1.5A1.5 1.5 0 0 0 2.5 7H4V4H1zm12 0v3h1.5A1.5 1.5 0 0 0 15 6.5V4h-3zm-3 10h4a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-4a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5z"/>' +
                        '</svg>' +
                        '</button>';
                    tableBody += '</div>';
                    tableBody += '</td>';
                    tableBody += '</tr>';
                });
                document.getElementById('dataTable').getElementsByTagName('tbody')[0].innerHTML = tableBody;
            })
            .catch(function(error) {
                // Manipule os erros aqui
                console.error(error);
            });
    }
</script>