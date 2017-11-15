<table class="table table-striped" style="text-align: justify; width: 100%;">
    <thead>
        <th>
            <?=ProjectModule::t('id')?>
        </th>
        <th>
            <?=ProjectModule::t('Description')?>
        </th>
        <th>
            <?=ProjectModule::t('Link')?>
        </th>
        <th>
            <?=ProjectModule::t('Date and time')?>
        </th>
    </thead>
    <?php foreach ($events as $key=>$eventGroups) { ?>
         <tr data-id="<?=$key?>" data-type="<?=$event->type?>">
            <td><?php echo $key?></td>
            <td>
                <?php foreach ($eventGroups['events'] as $event) { ?>
                    <?php echo ProjectModule::t($event->description).' '?>
                    <?php if($eventGroups['showLink']) { ?>
                        <a href="http://<?= $_SERVER['SERVER_NAME'] ?>/project/zakaz/update/id/<?= $event->event_id ?>">
                            <?= '#'.$event->event_id ?>
                        </a>
                    <?php } ?>
                    <br>
                <?php } ?>
            </td>
            <td>
                <?php
                echo CHtml::button(Yii::t('site', 'Delete'), array('onclick' => 'this.parentNode.parentNode.style.display=\'none\';$.post("' . Yii::app()->createUrl('project/event/delete', array('id' => $key, 'is_managerSale'=>$eventGroups['is_managerSale'])) . '",function(xhr,data,msg){ /*alert(xhr.msg);*/},"json");'));
                echo $eventGroups['action']['button'];
                ?>
            </td>
            <td><?php echo date("Y-m-d H:i", $eventGroups['timestamp']); ?></td>
         </tr>
        <?php } ?>
</table>
