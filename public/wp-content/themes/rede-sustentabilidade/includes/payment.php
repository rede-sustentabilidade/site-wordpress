<?php

// function rs_payment_menu()
// {
//     add_menu_page('Contribuições recorrentes', 'Contribuições recorrentes', 'administrator', 'rs-payment-profile', 'rs_payment_profile', 'dashicons-backup');
//     add_submenu_page('rs-payment-profile', 'Filiados contribuintes', 'Filiados contribuintes', 'administrator', 'rs-payment-profile', 'rs_payment_profile');
//     add_submenu_page('rs-payment-profile', 'Contribuições processadas', 'Contribuições processadas', 'administrator', 'rs-payment-payment', 'rs_payment_payment');
// }

// add_action('admin_menu', 'rs_payment_menu');

function rs_payment_profile()
{
    $api = ApiRede::getInstance();
    $profiles = $api->getPaymentProfiles();
?>
<div class="wrap">
    <h2>Filiados contribuintes</h2>
    <br class="clear">

    <table class="wp-list-table widefat fixed posts" cellspacing="0">
    	<thead>
    	    <tr>
    		    <th scope="col" id="title" class="manage-column column-title">Nome</th>
    		    <th scope="col" id="phone" class="manage-column column-phone">Telefones</th>
    		    <th scope="col" id="document" class="manage-column column-document">CPF</th>
    		    <th scope="col" id="mother" class="manage-column column-mother">Nome da mãe</th>
    		    <th scope="col" id="date" class="manage-column column-date">Data de nasc.</th>
    		    <th scope="col" id="contrib" class="manage-column column-contrib">Doação</th>
		    </tr>
    	</thead>

    	<tfoot>
        	<tr>
    		    <th scope="col" class="manage-column column-title">Nome</th>
    		    <th scope="col" class="manage-column column-phone">Telefones</th>
    		    <th scope="col" class="manage-column column-document">CPF</th>
    		    <th scope="col" class="manage-column column-mother">Nome da mãe</th>
    		    <th scope="col" class="manage-column column-date">Data de nasc.</th>
    		    <th scope="col" class="manage-column column-contrib">Doação</th>
    		</tr>
    	</tfoot>

    	<tbody id="the-list">

            <?php $i = 0; foreach ($profiles as $profile) : ?>
			<tr id="payment-<?php echo $profile->user_id; ?>" class="profile-<?php echo $profile->user_id; ?> <?php if ($i % 2 == 0) echo 'alternate'; ?>" valign="top">
    		    <td class="title column-title"><?php echo $profile->fullname; ?></td>
    		    <td class="phone column-phone">
                    <?php $phones = array(
                        'Residencial' => $profile->telefone_residencial,
                        'Celular' => $profile->telefone_celular,
                        'Comercial' => $profile->telefone_comercial,
                    ); ?>
                    <?php $i = 0; foreach ($phones as $name => $phone) : if (empty($phone)) continue; ?>
                    <?php if ($i > 0) echo '<br>'; ?>
                    <?php echo $name.': <strong>'.$phone.'</strong>'; ?>
                    <?php $i++; endforeach; ?>
    		    </td>
    		    <td class="document column-document"><?php echo $profile->cpf; ?></td>
    		    <td class="mother column-mother"><?php echo $profile->nome_mae; ?></td>
    		    <td class="date column-date"><?php echo $profile->birthday; ?></td>
    		    <td class="contrib column-contrib"><?php echo $profile->contribuicao; ?></td>
			</tr>
			<?php $i++; endforeach; ?>

		</tbody>
    </table>
    <br class="clear">
</div>
    <?php
}

function rs_payment_payment()
{
    $api = ApiRede::getInstance();
    $payments = $api->getPayments();
    ?>
<div class="wrap">
    <h2>Contribuições processadas</h2>
    <br class="clear">

    <table class="wp-list-table widefat fixed posts" cellspacing="0">
    	<thead>
    	    <tr>
    		    <th scope="col" id="title" class="manage-column column-title">Filiado</th>
    		    <th scope="col" id="phone" class="manage-column column-phone">Telefones</th>
    		    <th scope="col" id="contrib" class="manage-column column-contrib">Doação</th>
    		    <th scope="col" id="return" class="manage-column column-return">Retorno</th>
    		    <th scope="col" id="transaction" class="manage-column column-transaction">Transação</th>
    		    <th scope="col" id="date" class="manage-column column-date">Data</th>
		    </tr>
    	</thead>

    	<tfoot>
        	<tr>
        		<th scope="col" class="manage-column column-title">Filiado</th>
        		<th scope="col" class="manage-column column-phone">Telefones</th>
        		<th scope="col" class="manage-column column-contrib">Doação</th>
        		<th scope="col" class="manage-column column-return">Retorno</th>
        		<th scope="col" class="manage-column column-transaction">Transação</th>
        		<th scope="col" class="manage-column column-date">Data</th>
    		</tr>
    	</tfoot>

    	<tbody id="the-list">

            <?php $i = 0; foreach ($payments as $payment) : ?>
			<tr id="payment-<?php echo $payment->id; ?>" class="payment-<?php echo $payment->id; ?> <?php if ($i % 2 == 0) echo 'alternate'; ?>" valign="top">
    			<td class="title column-title">
    			    <?php if (!empty($payment->profile)) : ?>
    			    <strong><a class="row-title" href="#"><?php echo $payment->profile->fullname; ?></a></strong><br>
    			    <?php echo $payment->profile->cpf; ?> | <?php echo $payment->profile->nome_mae; ?> | <?php echo $payment->profile->birthday; ?>
    			    <?php else : ?>-<?php endif; ?>
                </td>
                <td class="contact column-phone">
    			    <?php if (!empty($payment->profile)) : ?>
                    <?php $phones = array(
                        'Residencial' => $payment->profile->telefone_residencial,
                        'Celular' => $payment->profile->telefone_celular,
                        'Comercial' => $payment->profile->telefone_comercial,
                    ); ?>
                    <?php $i = 0; foreach ($phones as $name => $phone) : if (empty($phone)) continue; ?>
                    <?php if ($i > 0) echo '<br>'; ?>
                    <?php echo $name.': <strong>'.$phone.'</strong>'; ?>
                    <?php $i++; endforeach; ?>
    			    <?php else : ?>-<?php endif; ?>
                </td>
    			<td class="categories column-contrib"><?php echo 'R$ '.number_format($payment->amount / 100, 2, ',', '.') ?> | **** **** **** <?php echo $payment->number; ?></td>
    			<td class="tags column-return"><?php echo $payment->return_code.' - '.$payment->return_message; ?></td>
    			<td class="comments column-transaction"><?php echo $payment->transaction_id; ?></td>
    			<td class="date column-date"><?php echo $payment->created_at; ?></td>
			</tr>
			<?php $i++; endforeach; ?>

		</tbody>
    </table>
    <br class="clear">
</div>
    <?php
}
