<?php

use yii\helpers\Html;

?>

<p>Hola,</p>
<p>Se ha creado una cuenta para usted en nuestro sistema. Para activarla, haga clic en el siguiente enlace:</p>
<p><?= Html::a('Activar Cuenta', $activationLink) ?></p>
<p>Si no solicitó esto, puede ignorar este correo.</p>
