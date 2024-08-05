<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td ><?= htmlspecialchars($transaction['id'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($transaction['date'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($transaction['check_number'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($transaction['description'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($transaction['amount'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php
                    $tot=0; 
                    foreach ($transactions as $transaction):
                        if($transaction['amount']>0){
                            $tot=$tot+$transaction['amount'];
                        }  
                    endforeach;
                         htmlspecialchars($tot, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php
                    $tot1=0; 
                    foreach ($transactions as $transaction):
                        if($transaction['amount']<0){
                            $tot1=$tot1+$transaction['amount'];
                        }  
                    endforeach;
                         htmlspecialchars($tot1, ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php htmlspecialchars($tot-$tot1, ENT_QUOTES, 'UTF-8')?> </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
