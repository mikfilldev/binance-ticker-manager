<?php
spl_autoload_register(function ($class) {
    $filename = str_replace('\\', '/', $class);
    $filename = str_replace('app', '.', $filename);
    require_once $filename . '.php';
});

use app\Controllers\CurrencyController;
use app\Services\CurrencyDataFetcher;
use app\Services\FileManager;

$url = 'https://www.binance.com/api/v3/ticker/price';
$filePath = __DIR__ . '/data.json';

$fetcher = new CurrencyDataFetcher($url);
$fileManager = new FileManager($filePath);
$controller = new CurrencyController($fetcher, $fileManager);

$controller->updateCurrencyData();

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$currencyPairs = $controller->getCurrencyPairs($filter);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BinanceTickers</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <form class="mx-auto p-2" method="GET" action="">
        <div class="input-group rounded">
            <input type="search" name="filter" class="form-control rounded" placeholder="Find ticker" aria-label="Find ticker" aria-describedby="search-addon" value="<?= htmlspecialchars($filter) ?>" />
            <button type="submit"><span class="input-group-text border-0" id="search-addon">
                    <i class="fas fa-search"></i>
                </span></button>
        </div>
    </form>
    <table class="table text-center">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ticker</th>
                <th scope="col">Price</th>
            </tr>

        </thead>
        <tbody class="table-group-divider">
            <?php if (!empty($currencyPairs)) : ?>
                <?php foreach ($currencyPairs as $key => $pair) : ?>
                    <tr>
                        <th scope="row"><?= $key + 1 ?></th>
                        <td><?= $pair->getSymbol() ?></td>
                        <td><?= rtrim(number_format($pair->getPrice(), 8), 0) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3">No matching results found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>