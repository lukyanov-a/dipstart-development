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
    <?php foreach ($events as $event) {?>
     <tr data-id="<?=$event->id?>" data-type="<?=$event->type?>">
        <td><?php echo $event->id?></td>
        <td><?php echo ProjectModule::t($event->description).' '?><a href="http://<?= $_SERVER['SERVER_NAME'] ?>/project/zakaz/update/id/<?= $event->event_id ?>"><?= '#'.$event->event_id ?></a></td>
        <td>
			<?php 
			echo CHtml::button(Yii::t('site','Delete'),array('onclick'=>'this.parentNode.parentNode.style.display=\'none\';$.post("'.Yii::app()->createUrl('project/event/delete',array('id'=>$event->id)).'",function(xhr,data,msg){ /*alert(xhr.msg);*/},"json");'));
            switch ($event->type) {
                case EventHelper::TYPE_EDIT_ORDER:
                case EventHelper::TYPE_UPDATE_PROFILE:
                    echo CHtml::link(
                            Yii::t('site','Show'),
                            Yii::app()->createUrl('moderate/index', ['id' => $event->id])
                        );
                break;
                case EventHelper::TYPE_NOTIFICATION:
                    echo '<td>'.Yii::t('site','Link is absent').'</td>';
                break;
                case EventHelper::TYPE_MESSAGE:
                default:
                    echo CHtml::link(Yii::t('site', 'Show'), ['/project/zakaz/preview', 'id' => $event->id]);
                break;
            }?>
        </td>
        <td><?php echo date("Y-m-d H:i", $event->timestamp); ?></td>
     </tr>
    <?php } ?>
</table>