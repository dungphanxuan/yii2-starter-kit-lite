<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
use yii\helpers\Html;

$this->title = Yii::t('admin', 'System Information');
?>
<?php echo Yii::t(
    'admin',
    'Sorry, application failed to collect information about your system. See {link}.',
    ['link' => Html::a('trntv/probe', 'https://github.com/trntv/probe#user-content-supported-os')]
);
