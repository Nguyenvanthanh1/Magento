define([
        "jquery", "Magento_Ui/js/modal/modal"
    ], function($){
    $('#modal_content').modal({
        buttons: [{
            text: 'Show',
            class: '',
            click: function () {
                alert('helo')
            } //handler on button click
        }]
    })
    }
);
