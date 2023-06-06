<?php

echo ($_GET['busca']);
?>
<script>
    function captureKey(value) {
        return value;
    }
</script>



<div class="d-flex justify-content-center align-items-center ">

    <form class="row  needs-validation  " novalidate method="post" action="">
        <div class="">

            <div class="d-flex  gap-2">
                <div class="col-sm-4">
                    <label for="validationCustom01" class="form-label">CPF</label>
                    <input type="text" class="form-control" onkeydown="captureKey(this.value)" id="cpf" name="cpf" placeholder="000.000.000-00" minlength="14" maxlength="14" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="validationCustom02" class="form-label">nome</label>
                    <input type="text" class="form-control" id="validationCustom02" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex  gap-2">

                <div class="col-sm-2">
                    <label for="validationCustom02" class="form-label">produto</label>
                    <input type="email" class="form-control" id="validationCustom02" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="validationCustom02" class="form-label">quantidade</label>
                    <input type="number" class="form-control" min="0" id="validationCustom02" required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="validationCustom02" class="form-label">valor unitário</label>
                    <input type="text" class="form-control" min="0" id="validationCustom02" disabled required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="validationCustom02" class="form-label">valor parcial</label>
                    <input type="text" class="form-control" min="0" id="validationCustom02" disabled required>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
        <div class="mt-2">
            <button class="btn btn-primary" type="submit">adicionar produto +</button>
        </div>
    </form>
</div>