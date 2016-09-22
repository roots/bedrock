/**
 * vote.js. Created by jeremydesvaux the 16 mai 2014
 */
(function($,ns) {

    "use strict";

    /**
     * init module scripts, relative to its context (multiple context of the same module may exist in a page)
     * @param jQuery $context wraper div of the module
     */
    var vote = function($context) {
        this.$context = $context;
        this.init();
    };

    vote.prototype = {
        init: function(){
            this.registerFormSubmit();
            this.registerVoteChange();
        },
        registerFormSubmit: function(){
            var t = this;
            t.$context.find('form.voteForm').on('submit',function(e){
                e.preventDefault();
                var $form = $(this);
                $form.addClass('loading').find('input[type="submit"]').attr('disabled', 'disabled');
                $.post($(this).attr('action'),$(this).serializeArray(),function(res){
                    var notifComponent = ns.app.getComponent('notification');

                    if(res && res.code && res.code==200){
                        notifComponent.show('success',res.data.msg,t.$context);
                    } else {
                        notifComponent.show('error',res.data.msg || 'Error',t.$context);
                    }
                    $form.removeClass('loading').find('input[type="submit"]').removeAttr('disabled','disabled');
                });
            })
        },
        registerVoteChange: function(){
            var t = this;
            t.$context.find('input.radio').on('change',function(){
                t.$context.find('form.voteForm').submit();
            });
        }
    };

    ns.app.registerModule('vote',vote);

})(jQuery,window.wonderwp);