<?php
include '_logic.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="../../dist/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <style>
        /* fallback */
        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/materialicons/v50/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.woff2) format('woff2');
        }

    </style>

</head>

<body>

<figure style="text-align: center">
    <img src="https://static.wixstatic.com/media/39e409_72945b8a24994411a581b07fe6445441~mv2.png/v1/crop/x_1102,y_0,w_4267,h_3240/fill/w_1114,h_838,al_c,q_90,usm_0.66_1.00_0.01/C%C3%B3pia%20de%20Logo.webp"
         style="height: 200px;"/>
</figure>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <br><br>
        <h1 class="header center orange-text" style="margin-top: -50px;">
            <?php
            if ($processar_resultados) {
                print $resultado;
                print '<hr/>';
            } else {
                print 'Sorteio da Ação de Dia das Mães do Comida com Amor';
            }
            ?>
        </h1>
        <div class="row center">
            <?php
            if (!$processar_resultados) {
                ?>
                <?php if (count($resultados_existentes) < 3) : ?>
                    <form method="post">
                        <button class="btn-large waves-effect waves-light orange">
                            Sortear agora!
                        </button>
                    </form>
                <?php endif ?>
                <?php
            } else {
                ?>
                <a href="." class="btn-large waves-effect waves-light orange">
                    Vamos ao próximo sorteio
                </a>
                <?php
            }
            ?>
        </div>
        <br><br>

    </div>
</div>

<?php
if (!$processar_resultados) {
    ?>

    <div class="container">
        <div class="section">

            <?php
            if (isset($resultados_existentes) && !empty($resultados_existentes)) {
                ?>

                <h1 class="header center orange-text" style="margin-top: -50px;">
                    <?php
                    if (isset($resultados_existentes) && count($resultados_existentes) === 3) {
                        ?>
                        Resultados Finais
                        <?php
                    } else {
                        ?>
                        Resultados
                        <?php
                    }
                    ?>
                </h1>

                <table style="width:100%" class="striped">
                    <tr>
                        <th>Prêmio</th>
                        <th>Doação Premiada</th>
                        <th>Cupom</th>
                        <th>Registro</th>
                    </tr>
                    <?php
                    foreach ($resultados_existentes as $key => $resultado) {
                        print '<tr>';
                        print '<td>#' . (3 - $key) . '</td>';
                        print '<td style="text-align:center">' . $resultado[0] . '</td>';
                        print '<td style="text-align:center">' . $resultado[1] . '</td>';
                        print '<td>' . $resultado[2] . '</td>';
                        print '</tr>';
                    }
                    ?>
                </table>
                <?php
            }
            ?>

            <h1 class="header center orange-text">
                Totalização de doações
            </h1>

            <table class="striped">
                <?php
                foreach ($results as $result) {
                    print '<tr>';
                    print '<th>' . $result['title'] . '</th>';
                    print '<td>' . $result['value'] . '</td>';
                    print '</tr>';
                }
                ?>
            </table>

            <h1 class="header center orange-text">
                Detalhamento das doações
            </h1>

            <table class="striped">
                <tr>
                    <th>Data</th>
                    <th>ID doação</th>
                    <th>Valor doado</th>
                    <th>Qtd Cupons</th>
                    <th>Cupons</th>
                </tr>
                <?php
                foreach ($doacoes as $doacao) {
                    print '<tr>';
                    foreach ($doacao as $coluna) {
                        print '<td style="text-align:center">' . $coluna . '</td>';
                    }
                    print '<td>';
//            print $doacao[1];
                    print implode(', ', $cupons[$doacao[1]]['items']);
//        foreach ($cupons[$doacao[1]]['items'] as $cupom) {
//            print '<li>' . $cupom . '</li>';
//        }
                    print '</td>';
                    print '</tr>';
                }
                ?>
            </table>

        </div>
        <br><br>
    </div>

    <?php
}
?>

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
