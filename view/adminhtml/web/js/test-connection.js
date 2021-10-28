define([
    'ko',
    'uiComponent',
    'jquery'
], function (ko, Component, $) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'PerfectCode_StoresConfigButton/test_connection',
            connectionFailedMessage: '',
            fieldsToTest: {},
            url: '',
            success: false,
            message: '',
            visible: false
        },

        /**
         * Init observable variables
         * @return {Object}
         */
        initObservable: function () {
            this._super()
                .observe([
                    'success',
                    'message',
                    'visible'
                ]);

            return this;
        },

        /**
         * @override
         */
        initialize: function () {
            this._super();
            this.messageClass = ko.computed(function () {
                return 'message-validation message message-' + (this.success() ? 'success' : 'error');
            }, this);
        },

        /**
         * @param {Boolean} success
         * @param {String} message
         */
        showMessage: function (success, message) {
            this.message(message);
            this.success(success);
            this.visible(true);
        },

        /**
         * Send request to server to test connection action.
         */
        testConnection: function () {
            this.visible(false);

            var postData = [];
            $.each(this.fieldsToTest, function (key, fieldId) {
                postData[fieldId] = document.getElementById(fieldId).value;
            });

            $.ajax({
                type: 'POST',
                url: this.url,
                dataType: 'json',
                data: Object.assign({}, postData),
                success: function (response) {
                    this.showMessage(response.success === true, response.message);
                }.bind(this),
                error: function () {
                    this.showMessage(false, this.connectionFailedMessage);
                }.bind(this)
            });
        }
    });
});
