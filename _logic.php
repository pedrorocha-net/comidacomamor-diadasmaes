<?php

if ($_ENV["REQUEST_METHOD"] == 'GET') {
    $processar_resultados = FALSE;

    $dados_processados = processarDados();
    $doacoes = $dados_processados['doacoes'];
    $cupons = $dados_processados['cupons'];
    $cupom_id = $dados_processados['cupom_id'];
    $results = $dados_processados['results'];

    $resultados_existentes = pegarResultados();
} else {
    $processar_resultados = TRUE;

    $dados_processados = processarDados();
    $doacoes = $dados_processados['doacoes'];
    $cupons = $dados_processados['cupons'];
    $cupom_id = $dados_processados['cupom_id'];
    $results = $dados_processados['results'];

    $resultados_existentes = pegarResultados();
    $cupom_sorteado = mt_rand(1, $cupom_id);
    foreach ($resultados_existentes as $key => $resultado) {
        if ($cupom_sorteado == $resultado[0]) {
            $cupom_sorteado = mt_rand(1, $cupom_id);
        }
    }

    $doacao_sorteada = NULL;
    foreach ($cupons as $doacao_id => $doacao) {
        foreach ($cupons[$doacao_id]['items'] as $cupom_id) {
            if ($cupom_id == $cupom_sorteado) {
                $doacao_sorteada = $doacao_id;
            }
        }
    }


    $data_da_votacao = time();
    $resultado = 'No dia ' . date('d/m/Y', $data_da_votacao) . ', às ' . date('h:i:s', $data_da_votacao) . ' horas, o cupom ' . $cupom_sorteado . ' foi sorteado dentre ' . $cupom_id . ' cupons';

    salvarResultado($doacao_sorteada, $cupom_sorteado, $resultado);
}

function processarDados()
{
    $dados = file('./diadasmaes_doacoes.csv');

    $doacoes = [];
    $cupons = [];
    $cupom_id = 0;
    $results = [];

    foreach ($dados as $row) {
        $item = explode(';', $row);
        $item[0] = str_replace('2020maio 7, 2020', '5/2020', $item[0]);
        $item[0] = str_replace('2020maio 8, 2020', '5/2020', $item[0]);
        $item[0] = str_replace('2020maio 9, 2020', '5/2020', $item[0]);
        $item[0] = str_replace('05/', '', $item[0]);
        unset($item[2]);
        unset($item[3]);
        $cupons[$item[1]] = [
            'doacao_id' => $item[1],
            'items' => [],
        ];
        for ($i = 0; $i < $item[5]; $i++) {
            $cupons[$item[1]]['items'][] = ++$cupom_id;
        }
        $doacoes[] = $item;
    }

    $results[] = [
        'title' => 'Total de doadores',
        'value' => count($doacoes),
    ];
    $results[] = [
        'title' => 'Total de cupons',
        'value' => $cupom_id,
    ];

    return [
        'doacoes' => $doacoes,
        'cupons' => $cupons,
        'cupom_id' => $cupom_id,
        'results' => $results,
    ];
}

function salvarResultado($doacao_id, $cupom_id, $resultado)
{
    $resultados = json_decode(file_get_contents('resultados.json'), TRUE);

    $resultados[] = [
        $doacao_id,
        $cupom_id,
        $resultado
    ];

    file_put_contents('resultados.json', json_encode($resultados));
}

function pegarResultados()
{
    return json_decode(file_get_contents('resultados.json'), TRUE);
}


?>
