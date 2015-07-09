
<div id="project_payments" class="col-xs-12">

    <h4>Оплаты</h4>
    <table class="table table-striped paytable">
       <tr>
            <td>
                Стоимость проекта:
            </td>
            <td>
                <input type="text" class="project_price_input" size="10" value="<?php echo $model->project_price; ?>"/>
            </td>
            
        </tr>
        <tr>
            <td>
                Получено от клиента:
            </td>
            <td>
                <b><span class="payment_received"><?php echo $model->received; ?></span></b>
            </td>
        </tr>
        <tr>
            <td>
                Выписать счет:
            </td>
            <td>
                <input type="text" size="10" class="to_receive_input" value=""/>
            </td>
        </tr>
        <tr>
            <td>
                Стоит на оплате:
            </td>
            <td>
                <b><span class="payment_to_receive"><?php echo $model->to_receive; ?></span></b>
            </td>
        </tr>
        <tr>
            <td>
                Подтвердить платеж:
            </td>
            <td>
                <div class="btn-group-xs" role="group">
                <button class="btn btn-default send_managers_approve">Подтвердить</button>
                <button class="btn btn-default send_managers_cancel">Отмена</button>
                <?php 
                    if ($zakaz->payment_image) {
                        echo CHtml::link('Чек', UploadPaymentImage::PAYMENT_DIR . $zakaz->payment_image);
                    }
                ?>
                </div>
            </td>
        </tr>
    </table>
    <table class="table table-striped paytable">
       <tr>
            <td>
                Стоимость для автора:
            </td>
            <td>
                <input type="text" class="work_price_input" size="10" value="<?php echo $model->work_price; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                Оплачено работы:
            </td>
            <td>
                <b><span class="payment_payed"><?php echo $model->payed; ?></span></b>
            </td>
            </td>
        </tr>
        <tr>
            <td>
                Отправить на оплату:
            </td>
            <td>
                <input type="text" size="10" class="to_pay_input" value="" <?php if($model->received=='') echo 'disabled';?>/>
            </td>
        </tr>
        <tr>
            <td>
                Суммарно на оплату:
            </td>
            <td>
                <b><span class="payment_to_pay"><?php echo $model->to_pay; ?></span></b>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td>
                
            </td>
        </tr>
    </td>
    </table>
    <button class="btn btn-primary pay-save-btn send_user_payments">Сохранить</button>
    </div>

<script type="text/javascript">
    $(document).ready(function () {
        var projectPayments = new ProjectPayments(<?php echo $projectId; ?>);
    });
</script>