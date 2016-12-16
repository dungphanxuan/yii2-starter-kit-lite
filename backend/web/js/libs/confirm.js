/**
 * Created by developer on 5/16/2016.
 */
yii.allowAction = function ($e) {
    var message = $e.data('confirm');
    return message === undefined || yii.confirm(message, $e);
};
yii.confirm = function (message, ok, cancel) {
    bootbox.confirm({
        title: false,
        message: 'Are you sure you want to delete this item?',
        buttons: {
            'cancel': {
                label: 'Cancel',
                className: 'btn-default'
            },

        },
        callback: function (confirmed) {
            if (confirmed) {
                !ok || ok();
            } else {
                !cancel || cancel();
            }
        }
    });
    // confirm will always return false on the first call
    // to cancel click handler
    return false;
}