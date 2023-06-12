<?php $month = date('F');
$monthNumber = date_parse($month)['month']; ?>
<div class="d-flex  " style="justify-content: space-between;">

    <div class="card text-bg-light mb-3" style="max-width:18rem">
        <div class="card-header">Vendas no mês</div>
        <div class="card-body">
            <h5 class="card-title">
            </h5>
            <p class="card-text "><?php echo $this->data[0][$monthNumber - 1]; ?></p>
        </div>
    </div>

    <div class="card text-bg-light mb-3" style="max-width:18rem">
        <div class="card-header">Compras no mes</div>
        <div class="card-body">
            <h5 class="card-title">
            </h5>
            <p class="card-text "><?php echo $this->data[1][$monthNumber - 1]; ?></p>
        </div>
    </div>
</div>