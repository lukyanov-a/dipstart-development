<?php
Yii::app()->getClientScript()->registerScriptFile('/js/tinymce/tinymce.min.js');
?>

<div class="emails-form">
    <?php echo CHtml::beginForm(); ?>
    <div class="row">
		<label><?=ProjectModule::t('Recipients')?>:</label>
        <select id="select_recipients" class="select_recipients" name="recipients">
            <option value="" selected><?= ProjectModule::t('Not selected')?></option>
            <option value="executors"><?= ProjectModule::t('to executors')?></option>
            <option value="customers"><?= ProjectModule::t('to customers')?></option>
        </select>
    </div>
    <div class="row">
        <label><?=ProjectModule::t('Topic')?>:</label><input type="text" id="emails-title" name="title" value="<?= $title ?>">
    </div>
    <div class="row">
        <textarea id="emails-message" name="message"><?= $message ?></textarea>
    </div>
    <div class="row emails-subm">
        <button class="emails-submit1"><?=ProjectModule::t('Send message')?></button><span class="result"><?php echo $result; ?></span>
    </div>
    <?php echo CHtml::endForm(); ?>
    
    <script>
        tinymce.init({ selector:'textarea' });
        var send = $('button.emails-submit1');
        send.click(function () {
            var text = tinymce.get('emails-message').getContent();
            //alert(text);
            $('form').submit();
            /*actionPost(text, function (ok) {
                if (ok == true) {
                    tinymce.get('chat_message').setContent('');
                    msg.data('index', 0);
                    $(this).data('recipient', 0);
                    scroll();
                    setTimeout(function () {
                        msg.focus();
                    }, 100);
                }
            },
                {
                    index: msg.data('index'),
                    recipient: $(this).data('recipient'),
                    flags: Array.prototype.map.call( $("input:checkbox:checked"), function( input ) {return input.id;})
                }
            );*/
        });
    </script>
</div>