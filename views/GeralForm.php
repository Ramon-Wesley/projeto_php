<?php
session_start();
if (!empty($this->data2)) {
    $keys = array_keys($this->data2);
    $lengthKey = count($keys);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $res = array();
    $postData = array_map('sanitizeString', $_POST);
    unset($postData['submit']);
    $res = $this->create($postData);
}

function sanitizeString($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<div class="container">
    <!-- Adicione antes do botão "Cadastrar" -->

    <div id="error-message" class="alert alert-danger" style="display: none;"></div>
    <div id="success-message" class="alert alert-success" style="display: none;"></div>

    <form id="cadastroForm" method="POST" action="" class="border p-4">
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmação de Cadastro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza de que deseja cadastrar?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" data-bs-dismiss="modal" class="btn btn-success">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h2>Cadastro</h2>
            <div class="col-mb-12 d-flex flex-wrap gap-2 align-items-center">
                <?php
                if (!empty($lengthKey)) {
                    foreach ($keys as $key) {
                        $errorClass = isset($res[$key]) ? 'is-invalid' : '';
                        $errorMessage = isset($res[$key]) ? '<div class="invalid-feedback">' . $res[$key] . '</div>' : '';
                        $fieldValue = isset($postData[$key]) ? htmlspecialchars($postData[$key], ENT_QUOTES, 'UTF-8') ??  $this->data[strtolower($key)] : $this->data[strtolower($key)];

                        echo '<div class="col-mb-4">
                            <label for="' . $key . '" class="form-label">' . $key . '</label>';

                        if ($key === 'Categoria') {
                            echo '<select class="form-select ' . $errorClass . '" id="' . $key . '" name="' . $key . '">';
                            echo '<option value="">Selecione a categoria</option>';

                            foreach ($this->data['categories'] as $category) {
                                $selected = $fieldValue === $category['id'] ? 'selected' : '';
                                echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['nome'] . '</option>';
                            }

                            echo '</select>';
                        } else {
                            echo '<input type="' . $this->data2[$key] . '" class="form-control ' . $errorClass . '" id="' . $key . '" name="' . $key . '" placeholder="Digite o ' . $key . '" value="' . $fieldValue . '">';
                        }
                        echo $errorMessage . '
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
        <!-- Adicione o atributo data-bs-toggle e data-bs-target -->
        <button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#confirmModal">Cadastrar</button>
        <input type="hidden" name="confirmar" value="1">
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessageElement = document.getElementById('success-message');
        var errorMessage = '<?php echo !is_array($res) ? $res : ''; ?>';

        if (errorMessage !== '') {
            errorMessageElement.innerText = errorMessage;
            errorMessageElement.style.display = 'block';
            errorMessageElement.classList.add('show');

            setTimeout(function() {
                errorMessageElement.classList.remove('show');
                errorMessageElement.style.display = 'none';
            }, 2000);
        }

        <?php if (empty($res)) { ?> // Verifica se não há erros
            var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal')); // Cria uma instância do modal

            var confirmButton = document.getElementById('confirmButton'); // Adicione um id ao botão "Confirmar" do modal
            confirmButton.addEventListener('click', function() {
                document.getElementById('cadastroForm').submit(); // Submete o formulário
                confirmModal.hide(); // Oculta o modal
            });

            confirmModal.show(); // Exibe o modal
        <?php } ?>
    });
</script>
<?php if (!empty($res) && isset($res['error'])) { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessageElement = document.getElementById('error-message');
            var errorMessage = '<?php echo $res["error"]; ?>';

            if (errorMessage !== '') {
                errorMessageElement.innerText = errorMessage;
                errorMessageElement.style.display = 'block';
                errorMessageElement.classList.add('show');

                setTimeout(function() {
                    errorMessageElement.classList.remove('show');
                    errorMessageElement.style.display = 'none';
                }, 2000);
            }
        });
    </script>
<?php } ?>
<?php if (!empty($res) && isset($res['success'])) { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessageElement = document.getElementById('success-message');
            var errorMessage = '<?php echo $res["success"]; ?>';

            if (errorMessage !== '') {
                errorMessageElement.innerText = errorMessage;
                errorMessageElement.style.display = 'block';
                errorMessageElement.classList.add('show');

                setTimeout(function() {
                    errorMessageElement.classList.remove('show');
                    errorMessageElement.style.display = 'none';
                }, 2000);
            }
        });
    </script>
<?php } ?>

<script src="/projeto_php/js/GeralForm.js"></script>